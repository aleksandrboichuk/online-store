<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'name-field.min' => 'Заговоловок має містити не менше 2-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 2-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'name-field' => ['string', 'min:2'],
            'seo-field' => ['string', 'unique:product_brands,seo_name', 'min:2'],
        ], $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands =  ProductBrand::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.brand.index', [
            'user' => $this->getUser(),
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.additional-to-products.brand.add',[
            'user' => $this->getUser(),
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

        // ======================= определяем активность чекбокса ======================
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        // ===================== Создание бренда ===============================
        ProductBrand::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        return redirect('/admin/brands')->with(['success-message' => 'Бренд успішно додано.']);
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
        $brand = ProductBrand::find($id);
        if(!$brand){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.additional-to-products.brand.edit',[
            'user' => $this->getUser(),
            'brand' => $brand
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
        $brand = ProductBrand::find($id);
        // ================ в случае старого сео не делать валидацию на уникальность==============
        if($request['seo-field'] == $brand->seo_name){
            $validator = $this->validator($request->except('seo-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            // ================ если сео все же изменили то проверить на уникальность ==============
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        // ======================= определяем активность чекбокса ======================
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        // ======================= обновляем запись в базе ======================
        $brand->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        return redirect('admin/brands')->with(['success-message' => 'Бренд успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductBrand::find($id)->delete();
        return redirect('admin/brands')->with(['success-message' => 'Бренд успішно видалено.']);
    }
}
