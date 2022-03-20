<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(){
        $colors = ProductColor::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.color.index', [
            'user' => $this->getUser(),
            'colors' =>$colors
        ]);
    }

    public function addColor(){

        return view('admin.additional-to-products.color.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddColor(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductColor::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Колір успішно додано.']);
        return redirect('/admin/colors');
    }
    public function editColor($color_id){
        $color = ProductColor::find($color_id);
        if(!$color){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.additional-to-products.color.edit',[
            'user' => $this->getUser(),
            'color' => $color
        ]);
    }

    public function saveEditColor(Request $request){
        $color = ProductColor::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $color->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Колір успішно змінено.']);
        return redirect('admin/colors');
    }

    public function delColor($color_id){
        ProductColor::find($color_id)->delete();
        session(['success-message' => 'Колір успішно видалено.']);
        return redirect('admin/colors');
    }
}
