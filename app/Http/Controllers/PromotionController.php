<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request, $group_seo_name, $seo_name_banner){
        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }
        $group = CategoryGroup::where('seo_name',$group_seo_name)->first();
        $brands = $this->getGroupBrand($group->id);

        $banner = Banner::where('seo_name', $seo_name_banner)->first();
        $products = Product::where('banner_id', $banner->id)->where('category_group_id', $group->id)->paginate(6);


        /*----------------------  AJAX  ----------------------*/

        if((!empty($request->colors)) || (!empty($request->brands)) || (!empty($request->materials))  || (!empty($request->seasons)) || (!empty($request->sizes))  || (!empty($request->from_price)) || (!empty($request->to_price))){
            $products = Product::where('category_group_id',$group->id)->where('banner_id',$banner->id )->where('category_group_id', $group->id)
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
                })->when(!empty($request->seasons), function($query){
                    if(request('seasons') == "Всі"){
                        return $query->where('product_season_id',"!=", 0);
                    }
                    $season = ProductSeason::where('name', request('seasons'))->first();
                    return $query->where('product_season_id',$season->id);

                })->when($request->to_price > $request->from_price, function($query){

                    return $query->whereBetween('price', [request('from_price'), request('to_price')]);
                })->when(isset($request->orderBy) && $request->orderBy != "none" , function($query){

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
                    foreach ($products as $key => $value) {
                        $is_material = false;
                        for ($a = 0; $a < $value->materials->count(); $a++) {
                            if ($value->materials[$a]['name'] == $request->materials) {
                                $is_material = true;
                                break;
                            }
                        }
                        if (!$is_material) {
                            unset($products[$key]);
                        }
                    }
                }
            }
            //найти размеры
            if(isset($request->sizes) && !empty($request->sizes)){
                if($request->sizes != "Всі") {
                    foreach ($products as $key => $value) {
                        $is_size = false;
                        for ($a = 0; $a < $value->sizes->count(); $a++) {
                            if ($value->sizes[$a]['name'] == $request->sizes) {
                                $is_size = true;
                                break;
                            }
                        }
                        if (!$is_size) {
                            unset($products[$key]);
                        }
                    }
                }
            }
            if($request->ajax()){

                return view('ajax.ajax',[
                    'products' => $products,
                    'group' => $group,
                    "images"=> ProductImage::all(),
                ])->render();
            }
        }

        return view('promotions.index', [
            'user'=> $this->getUser(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
            'banner'=> $banner ,
            'products' => $products,
            'group' => $group,
            'group_categories' => $group->categories,
            'brands' => $brands,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
            "images"=> ProductImage::all(),
        ]);
    }
}
