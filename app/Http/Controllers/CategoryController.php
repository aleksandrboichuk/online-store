<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index(Request $request, $group_seo_name,$category_seo_name){
        $group = CategoryGroup::where('seo_name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $category_products = Product::where('category_group_id',$group->id)->where('category_id',$category->id)->paginate(9);

        $group_brands = $this->getGroupBrand($group->id);

        /*----------------------  AJAX  ----------------------*/
        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }
        if((!empty($request->colors)) || (!empty($request->brands)) || (!empty($request->materials))  || (!empty($request->seasons)) || (!empty($request->sizes))|| (!empty($request->from_price)) || (!empty($request->to_price))){
            $category_products = Product::where('category_group_id',$group->id)->where('category_id',$category->id)
                ->when(!empty($request->colors), function($query){
                    if(request('colors') == "Всі"){
                        return $query->where('product_color_id',"!=", 0);
                    }
                    $color = ProductColor::where('name', request('colors'))->first();
                    return $query->where('product_color_id', $color->id);
                })
                ->when(!empty($request->brands), function($query){
                    if(request('brands') == "Всі"){
                        return $query->where('product_brand_id',"!=", 0);
                    }
                    $brand = ProductBrand::where('name', request('brands'))->first();
                    return $query->where('product_brand_id',$brand->id);
                })

                ->when(!empty($request->seasons), function($query){
                    if(request('seasons') == "Всі"){
                        return $query->where('product_season_id',"!=", 0);
                    }
                    $season = ProductSeason::where('name', request('seasons'))->first();
                    return $query->where('product_season_id',$season->id);
                })->when($request->to_price > $request->from_price, function($query){
                    return $query->whereBetween('price', [request('from_price'), request('to_price')]);
                })->when(isset($request->orderBy)  && $request->orderBy != "none" , function($query){
                    if(request('orderBy') == 'count'){
                        return $query->orderBy('count','desc');
                    }else if(request('orderBy') == 'price-asc'){
                        return $query->orderBy('price','asc');
                    }else if(request('orderBy') == 'price-desc'){
                        return $query->orderBy('price','desc');
                    }else{
                        return $query->orderBy('created_at','desc');
                    }
                })->paginate(9);

            // найти материалы
            if(isset($request->materials) && !empty($request->materials)){
                if($request->materials != "Всі"){
                    foreach ($category_products as $key => $value){
                        $is_material = false;
                        for($a = 0; $a < $value->materials->count(); $a++){
                            if($value->materials[$a]['name'] == $request->materials){
                                $is_material = true;
                                break;
                            }
                        }
                        if(!$is_material){
                            unset($category_products[$key]);
                        }
                    }
                }

            }
            if(isset($request->sizes) && !empty($request->sizes)){
                if($request->sizes != "Всі") {
                    foreach ($category_products as $key => $value){
                        $is_size = false;
                        for($a = 0; $a < $value->sizes->count(); $a++){
                            if($value->sizes[$a]['name'] == $request->sizes){
                                $is_size = true;
                                break;
                            }
                        }
                        if(!$is_size){
                            unset($category_products[$key]);
                        }
                    }
                }
            }
            if($request->ajax()){
                return view('ajax.ajax',[
                    'products' => $category_products,
                    'group' => $group,
                    "images"=> ProductImage::all(),
                ])->render();
            }
        }

        return view('category.category', [
            'user'=> $this->getUser(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
            'category_products' => $category_products,
            'category' =>$category,
            'group' => $group,
            'group_categories' => $group->categories,
            'brands' => $group_brands,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
            "images"=> ProductImage::all(),

        ]);

    }
    public function showSubCategoryProducts(Request $request, $group_seo_name,$category_seo_name,$sub_category_seo_name){
        $group = CategoryGroup::where('seo_name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $sub_category = SubCategory::where('seo_name',$sub_category_seo_name)->where('category_id',$category->id)->first();
        $sub_category_products = Product::where('category_group_id', $group->id)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)->paginate(9);

        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }
        /*----------------------  AJAX  ----------------------*/

        if((!empty($request->colors)) || (!empty($request->brands)) || (!empty($request->materials))  || (!empty($request->seasons)) || (!empty($request->sizes)) || (!empty($request->from_price)) || (!empty($request->to_price))){
        $sub_category_products = Product::where('category_group_id', $group->id)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)
            ->when(!empty($request->colors), function($query){
                if(request('colors') == "Всі"){
                    return $query->where('product_color_id',"!=", 0);
                }
                $color = ProductColor::where('name', request('colors'))->first();
                return $query->where('product_color_id', $color->id);
            })
            ->when(!empty($request->brands), function($query){
                if(request('brands') == "Всі"){
                    return $query->where('product_brand_id',"!=", 0);
                }
                $brand = ProductBrand::where('name', request('brands'))->first();
                return $query->where('product_brand_id',$brand->id);
            })
            ->when(!empty($request->seasons), function($query){
                if(request('seasons') == "Всі"){
                    return $query->where('product_season_id',"!=", 0);
                }
                $season = ProductSeason::where('name', request('seasons'))->first();
                return $query->where('product_season_id',$season->id);
            })->when($request->to_price > $request->from_price, function($query){
                return $query->whereBetween('price', [request('from_price'), request('to_price')]);
            })->when(isset($request->orderBy)  && $request->orderBy != "none" , function($query){
                if(request('orderBy') == 'count'){
                    return $query->orderBy('count','desc');
                }else if(request('orderBy') == 'price-asc'){
                    return $query->orderBy('price','asc');
                }else if(request('orderBy') == 'price-desc'){
                    return $query->orderBy('price','desc');
                }else{
                    return $query->orderBy('created_at','desc');
                }
            })->paginate(9);

        // найти материалы
        if(isset($request->materials) && !empty($request->materials)){
            if($request->materials != "Всі") {
                foreach ($sub_category_products as $key => $value) {
                    $is_material = false;
                    for ($a = 0; $a < $value->materials->count(); $a++) {
                        if ($value->materials[$a]['name'] == $request->materials) {
                            $is_material = true;
                            break;
                        }
                    }
                    if (!$is_material) {
                        unset($sub_category_products[$key]);
                    }
                }
            }
        }
        if(isset($request->sizes) && !empty($request->sizes)){
            if($request->sizes != "Всі") {
                foreach ($sub_category_products as $key => $value) {
                    $is_size = false;
                    for ($a = 0; $a < $value->sizes->count(); $a++) {
                        if ($value->sizes[$a]['name'] == $request->sizes) {
                            $is_size = true;
                            break;
                        }
                    }
                    if (!$is_size) {
                        unset($sub_category_products[$key]);
                    }
                }
            }
        }
        if($request->ajax()){
            return view('ajax.ajax',[
                'products' => $sub_category_products,
                'group' => $group,
                "images"=> ProductImage::all(),
            ])->render();
        }
    }

        $group_brands = $this->getGroupBrand($group->id);
        return view('SubCategory.subcategory',[
            'user'=> $this->getUser(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
           'sub_category_products' =>  $sub_category_products,
           'category' =>$category,
           'sub_category' => $sub_category,
            'group' => $group,
            'group_categories' => $group->categories,
           'brands' => $group_brands,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
            "images"=> ProductImage::all(),
        ]);
    }
}
