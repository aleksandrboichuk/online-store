<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return redirect('/women');
    }

    public function index($group_seo_name){
        $group = CategoryGroup::where('name',$group_seo_name)->first();
        $group_products = Product::where('category_group_id',$group->id)->get();

        $brands = ProductBrand::all();
        foreach ($brands as $brand) {
            foreach ($brand->products as $brand_product){
                if($brand_product->category_group_id == $group->id){
                    $group_brands[] = $brand;
                    break;
                }
            }
        }

        return view('index',[
           'group' => $group,
           'group_products' => $group_products,
           'group_categories' => $group->categories,
           'brands' => $group_brands,
        ]);

    }
}
