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

    public function index(){
        $brands =  ProductBrand::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.brand.index', [
            'user' => $this->getUser(),
            'brands' => $brands
        ]);
    }

    public function add(){

        return view('admin.additional-to-products.brand.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAdd(Request $request){

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
    public function edit($brand_id){
        $brand = ProductBrand::find($brand_id);
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

    public function saveEdit(Request $request){
        $brand = ProductBrand::find($request['id']);

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

    public function delete($brand_id){
        ProductBrand::find($brand_id)->delete();
        return redirect('admin/brands')->with(['success-message' => 'Бренд успішно видалено.']);
    }
}
