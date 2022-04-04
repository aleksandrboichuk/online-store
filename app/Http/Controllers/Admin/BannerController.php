<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

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

    //show adding form

    public function addBanner(){

        return view('admin.banner.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get(),
        ]);
    }

    //saving add

    public function saveAddBanner(Request $request){
        $banner = new Banner;
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $banner->create([
            'title' => $request['title-field'],
            'category_group_id' => $request['cat-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'active' => $active,
        ]);

        $getBanner = Banner::where('seo_name',$request['seo-field'])->first();
        // добавление картинок в хранилище и в БД

        $mainImageFile = $request->file('main-image-field');
//        $miniImageFile = $request->file('mini-image-field');
        Storage::disk('public')->putFileAs('banner-images/'.$getBanner->id, $mainImageFile, $mainImageFile->getClientOriginalName());
//        Storage::disk('public')->putFileAs('banner-images/'.$getBanner->id, $miniImageFile, $miniImageFile->getClientOriginalName());

        $getBanner->update([
            'image_url' => $mainImageFile->getClientOriginalName(),
//            'mini_img_url' => $miniImageFile->getClientOriginalName(),
        ]);

        session(['success-message' => 'Банер успішно додано.']);
        return redirect('/admin/banner');
    }

    //editing

    public function editBanner($banner_id){
        $banner = Banner::find($banner_id);

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


    //saving edit

    public function saveEditBanner(Request $request){

        $banner = Banner::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $banner->update([
            'title' => $request['title-field'],
            'category_group_id' => $request['cat-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // обновление картинок, если они были загружены
        if(isset($request['main-image-field'])){
            $mainImageFile = $request->file('main-image-field');
            Storage::disk('public')->delete('banner-images/'.$banner->id.'/' . $banner->image_url);
            Storage::disk('public')->putFileAs('banner-images/'.$banner->id.'/', $mainImageFile, $mainImageFile->getClientOriginalName());
            $banner->update([
                'image_url' => $mainImageFile->getClientOriginalName()
            ]);
        }

        if(isset($request['mini-image-field'])){
            $miniImageFile = $request->file('mini-image-field');
            Storage::disk('public')->delete('banner-images/'.$banner->id.'/' . $banner->mini_img_url);
            Storage::disk('public')->putFileAs('banner-images/'.$banner->id.'/', $miniImageFile, $miniImageFile->getClientOriginalName());
            $banner->update([
                'mini_img_url' => $miniImageFile->getClientOriginalName()
            ]);
        }

        session(['success-message' => 'Банер успішно змінено.']);
        return redirect("/admin/banner");
    }

    //delete

    public function delBanner($banner_id){
        $banner = Banner::find($banner_id);
        $banner->delete();

        Storage::disk('public')->deleteDirectory('banner-images/'.$banner->id);

        session(['success-message' => 'Банер успішно видалено.']);
        return redirect("/admin/banner");
    }
}
