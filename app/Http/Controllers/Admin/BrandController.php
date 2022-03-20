<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands =  ProductBrand::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.brand.index', [
            'user' => $this->getUser(),
            'brands' => $brands
        ]);
    }

    public function addBrand(){

        return view('admin.additional-to-products.brand.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddBrand(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductBrand::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Бренд успішно додано.']);
        return redirect('/admin/brands');
    }
    public function editBrand($brand_id){
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

    public function saveEditBrand(Request $request){
        $brand = ProductBrand::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $brand->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Бренд успішно змінено.']);
        return redirect('admin/brands');
    }

    public function delBrand($brand_id){
        ProductBrand::find($brand_id)->delete();
        session(['success-message' => 'Бренд успішно видалено.']);
        return redirect('admin/brands');
    }
}
