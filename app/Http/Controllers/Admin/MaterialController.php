<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'name-field.min' => 'Заговоловок має містити не менше 2-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 2-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'name-field' => ['string', 'min:2'],
            'seo-field' => ['string', 'unique:product_materials,seo_name', 'min:2'],
        ], $messages);
    }

    public function index(){
        $materials = ProductMaterial::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.material.index', [
            'user' => $this->getUser(),
            'materials' => $materials
        ]);
    }

    public function add(){

        return view('admin.additional-to-products.material.add',[
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
        ProductMaterial::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        return redirect('/admin/brands')->with(['success-message' => 'Матеріал успішно додано.']);
    }
    public function edit($material_id){
        $material = ProductMaterial::find($material_id);
        if(!$material){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.additional-to-products.material.edit',[
            'user' => $this->getUser(),
            'material' => $material
        ]);
    }

    public function saveEdit(Request $request){
        $material = ProductMaterial::find($request['id']);
        // ================ в случае старого сео не делать валидацию на уникальность==============

        if($request['seo-field'] == $material->seo_name){
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
        $material->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        return redirect('admin/materials')->with(['success-message' => 'Матеріал успішно змінено.']);
    }

    public function delete($material_id){
        ProductMaterial::find($material_id)->delete();
        return redirect('admin/materials')->with(['success-message' => 'Матеріал успішно видалено.']);
    }
}
