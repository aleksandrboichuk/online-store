<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Services\ElasticSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index($seo_names, Request $request, ElasticSearch $elasticSearch){
        $group = CategoryGroup::where('seo_name', $seo_names)->first();
        $products = $elasticSearch->search($seo_names, $request['q']);
        $view = 'search.cg-search';

        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }

        return view($view, [
            'products' => isset($products) ? $products : null,
            'group' =>  $group,
            'category' => isset($category) ? $category : null,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
            "images"=> ProductImage::all(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
        ]);



    }


    public function filtersRequest($seo_name, Request $request, ElasticSearch $elasticSearch){

        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }
        //explode query string
        $mainQueryString = explode('?', request()->getRequestUri());
        $arrSeoNames = explode('/', $mainQueryString[0]); // start from 2

        $group = CategoryGroup::where('seo_name',$arrSeoNames[2])->first();
        $group_brands = $this->getGroupBrand($group->id);

        $view = '';
        if(count($arrSeoNames) == 3){
            $view = 'index';
            $banners = Banner::where('active', 1)->get();
        }elseif(count($arrSeoNames) == 4){
            $view = 'category.category';
        }elseif(count($arrSeoNames) == 5){
            $view = 'SubCategory.subcategory';
        }

        $arData = [];

//        if(isset($request['sizes']) && !empty($request['sizes']) && isset($request['materials']) && !empty($request['materials'])) {
//            if(count(explode(',', $request['sizes'])) > 1 || count(explode(',', $request['materials'])) > 1) {
//                $filterType = 'filter';
//            } else {
//                $filterType = 'must';
//            }
//        } else {
//
//        }
        $filterType = 'should';
        if(isset($request['colors'])){
            $colors[] = explode(',', $request['colors']);
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'pc_seo_name' => $colors[0]
                ]
            ];
        }
        if(isset($request['brands'])){
            $brands[] = explode(',', $request['brands']);
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'pb_seo_name' => $brands[0]
                ]
            ];
        }
        if(isset($request['seasons'])){
            $seasons[] = explode(',', $request['seasons']);
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'ps_seo_name' => $seasons[0]
                ]
            ];
        }
        if(isset($request['materials'])){
            $materials[] = explode(',', $request['materials']);
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'pm_seo_name' => $materials[0]
                ]
            ];
        }
        if(isset($request['sizes'])){
            $sizes[] = explode(',', $request['sizes']);
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'psize_seo_name' => $sizes[0]
                ]
            ];
        }
     //   dd($arData);
        $products = $elasticSearch->searchByFilters($arrSeoNames[2],$arData);

        return view( $view, [
            'user' => $this->getUser(),
            'banners' => isset($banners) ? $banners : null,
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
            'group' =>  $group,
            'group_categories' => $group->categories,
            'products' => $products,
            'brands' => $group_brands,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
            "images"=> ProductImage::all(),

        ]);


    }
}
