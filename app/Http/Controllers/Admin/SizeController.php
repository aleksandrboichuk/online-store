<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(){
        $sizes =  ProductSize::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.size.index', [
            'user' => $this->getUser(),
            'sizes' => $sizes
        ]);
    }

    public function addSize(){

        return view('admin.additional-to-products.size.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddSize(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductSize::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Розмір успішно додано.']);
        return redirect('/admin/sizes');
    }
    public function editSize($size_id){
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

    public function saveEditSize(Request $request){
        $size = ProductSize::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $size->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Розмір успішно змінено.']);
        return redirect('admin/sizes');
    }

    public function delSize($size_id){
        ProductSize::find($size_id)->delete();
        session(['success-message' => 'Розмір успішно видалено.']);
        return redirect('admin/sizes');
    }
}
