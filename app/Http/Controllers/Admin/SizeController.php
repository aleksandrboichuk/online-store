<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'name-field.min' => 'Заговоловок має містити не менше 2-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 2-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'name-field' => ['string', 'min:2'],
            'seo-field' => ['string', 'unique:product_sizes,seo_name', 'min:2'],
        ], $messages);
    }

    public function index(){
        $sizes =  ProductSize::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.size.index', [
            'user' => $this->getUser(),
            'sizes' => $sizes
        ]);
    }

    public function add(){

        return view('admin.additional-to-products.size.add',[
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

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductSize::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        return redirect('/admin/sizes')->with(['success-message' => 'Розмір успішно додано.']);
    }
    public function edit($size_id){
        $size = ProductSize::find($size_id);
        if(!$size){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.additional-to-products.size.edit',[
            'user' => $this->getUser(),
            'size' => $size
        ]);
    }

    public function saveEdit(Request $request){
        $size = ProductSize::find($request['id']);
        // ================ в случае старого сео не делать валидацию на уникальность==============
        if($request['seo-field'] == $size->seo_name){
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
        $size->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        return redirect('admin/sizes')->with(['success-message' => 'Розмір успішно змінено.']);
    }

    public function delete($size_id){
        ProductSize::find($size_id)->delete();
        return redirect('admin/sizes')->with(['success-message' => 'Розмір успішно видалено.']);
    }
}
