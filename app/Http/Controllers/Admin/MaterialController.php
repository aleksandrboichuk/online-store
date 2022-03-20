<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductMaterial;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(){
        $materials = ProductMaterial::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.material.index', [
            'user' => $this->getUser(),
            'materials' => $materials
        ]);
    }

    public function addMaterial(){

        return view('admin.additional-to-products.material.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddMaterial(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductMaterial::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Матеріал успішно додано.']);
        return redirect('/admin/brands');
    }
    public function editMaterial($material_id){
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

    public function saveEditMaterial(Request $request){
        $material = ProductMaterial::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $material->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Матеріал успішно змінено.']);
        return redirect('admin/materials');
    }

    public function delMaterial($material_id){
        ProductMaterial::find($material_id)->delete();
        session(['success-message' => 'Матеріал успішно видалено.']);
        return redirect('admin/materials');
    }
}
