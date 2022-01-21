<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index($group_seo_name,$category_seo_name){
        $group = CategoryGroup::where('name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $category_products = Product::where('category_group_id',$group->id)->where('category_id',$category->id)->get();

        $brands = ProductBrand::all();
        foreach ($brands as $brand) {
            foreach ($brand->products as $brand_product){
                if($brand_product->category_group_id == $group->id){
                    $group_brands[] = $brand;
                    break;
                }
            }
        }
        return view('category.category', [
            'category_products' => $category_products,
            'category' =>$category,
            'group' => $group,
            'group_categories' => $group->categories,
            'brands' => $group_brands,

        ]);

    }
    public function showSubCategoryProducts($group_seo_name,$category_seo_name,$sub_category_seo_name){
        $group = CategoryGroup::where('name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $sub_category = SubCategory::where('seo_name',$sub_category_seo_name)->where('category_id',$category->id)->first();
        $sub_category_products = Product::where('category_group_id', $group->id)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)->get();


        $brands = ProductBrand::all();
        foreach ($brands as $brand) {
            foreach ($brand->products as $brand_product){
                if($brand_product->category_group_id == $group->id){
                    $group_brands[] = $brand;
                    break;
                }
            }
        }
        return view('SubCategory.subcategory',[
           'sub_category_products' =>  $sub_category_products,
           'category' =>$category,
           'sub_category' => $sub_category,
            'group' => $group,
            'group_categories' => $group->categories,
           'brands' => $group_brands,
        ]);
    }
}
