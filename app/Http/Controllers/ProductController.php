<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProductDetails ($group_seo_name,$category_seo_name,$sub_category_seo_name, $product_seo_name){
        $group = CategoryGroup::where('name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $sub_category = SubCategory::where('seo_name',$sub_category_seo_name)->where('category_id',$category->id)->first();
        $product = Product::where('category_group_id', $group->id)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)->where('seo_name',$product_seo_name)->first();

        $recommended_products = Product::where('category_group_id', $group->id)->inRandomOrder()->take(3)->get();

        $group_brands = $this->getGroupBrand($group->id);


        return view('product.product',[
             'group'  => $group,
             'category'  => $category,
             'sub_category'  => $sub_category,
             'product'  => $product,
            'group_categories' => $group->categories,
            'brands' => $group_brands,
            'recommended_products' =>$recommended_products,
            'product_img' => $product->images()
        ]);
    }

    public function changeImage(){

    }
}
