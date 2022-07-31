<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'title-field.min' => 'Заговоловок має містити не менше 3-х символів.',
            'description-field.min' => 'Опис має містити не менше 10-ти символів.',
            'seo-field.min' => 'СЕО має містити не менше 3-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'title-field' => ['string', 'min:3'],
            'description-field' => [ 'string', 'min:10'],
            'seo-field' => ['string', 'unique:banners,seo_name', 'min:3'],
        ], $messages);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param $cat_group
     */
    public function index($cat_group = null)
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        if (!empty($cat_group)) {
            switch ($cat_group) {
                case 'men':
                    $banners = Banner::where('category_group_id', 1)->orderBy('id', 'desc')->get();
                    break;
                case 'women':
                    $banners = Banner::where('category_group_id', 2)->orderBy('id', 'desc')->get();
                    break;
                case 'boys':
                    $banners = Banner::where('category_group_id', 3)->orderBy('id', 'desc')->get();
                    break;
                case 'girls':
                    $banners = Banner::where('category_group_id', 4)->orderBy('id', 'desc')->get();
                    break;
            }
        }
        return view('admin.banner.index',[
            'user'=>$this->getUser(),
            'banners' => $banners,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        //   Определение активности чекбокса
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $banner = Banner::create([
            'title' => $request['title-field'],
            'category_group_id' => $request['cat-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'active' => $active,
        ]);
        //   добавление картинок в хранилище и в БД
        $mainImageFile = $request->file('main-image-field');
        Storage::disk('banners')->putFileAs('banner-images/'.$banner->id, $mainImageFile, $mainImageFile->getClientOriginalName());
//        $miniImageFile = $request->file('mini-image-field');
//        Storage::disk('banners')->putFileAs('banner-images/'.$getBanner->id, $miniImageFile, $miniImageFile->getClientOriginalName());
        $banner->update([
            'image_url' => $mainImageFile->getClientOriginalName(),
//            'mini_img_url' => $miniImageFile->getClientOriginalName(),
        ]);
        return redirect('/admin/banners')->with(['success-message' => 'Банер успішно додано.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        //   в случае неправильной строки запроса отдать 404
        if(!$banner){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.banner.edit',[
            'user' => $this->getUser(),
            'banner' => $banner ,
            'category_groups' => CategoryGroup::all()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        //   в случае старого сео не делать валидацию на уникальность
        if($request['seo-field'] == $banner->seo_name){
            $validator = $this->validator($request->except('seo-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            //   если сео все же изменили то проверить на уникальность
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        //   определяем активность чекбокса
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        //   обновляем запись в базе
        $banner->update([
            'title' => $request['title-field'],
            'category_group_id' => $request['cat-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        //   обновление картинок, если они были загружены
        if(isset($request['main-image-field'])){
            $mainImageFile = $request->file('main-image-field');
            Storage::disk('banners')->delete('banner-images/'.$banner->id.'/' . $banner->image_url);
            Storage::disk('banners')->putFileAs('banner-images/'.$banner->id.'/', $mainImageFile, $mainImageFile->getClientOriginalName());
            $banner->update([
                'image_url' => $mainImageFile->getClientOriginalName()
            ]);
        }
//        if(isset($request['mini-image-field'])){
//            $miniImageFile = $request->file('mini-image-field');
//            Storage::disk('banners')->delete('banner-images/'.$banner->id.'/' . $banner->mini_img_url);
//            Storage::disk('banners')->putFileAs('banner-images/'.$banner->id.'/', $miniImageFile, $miniImageFile->getClientOriginalName());
//            $banner->update([
//                'mini_img_url' => $miniImageFile->getClientOriginalName()
//            ]);
//        }
        return redirect("/admin/banners")->with(['success-message' => 'Банер успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        //   удаление папки баннера в хранилище
        Storage::disk('public')->deleteDirectory('banner-images/'.$banner->id);

        return redirect("/admin/banners")->with(['success-message' => 'Банер успішно видалено.']);
    }
}
