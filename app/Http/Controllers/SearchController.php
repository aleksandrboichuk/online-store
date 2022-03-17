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
use App\Models\SubCategory;
use App\Services\ElasticSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index($group_seo_name, Request $request, ElasticSearch $elasticSearch){
        $group = CategoryGroup::where('seo_name', $group_seo_name)->where('active', 1)->first();

        $view = 'search.cg-search';
        $group_brands = $this->getGroupBrand($group->id);

        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }

        if(isset($request['orderBy'])){
            $sort = $request['orderBy'];
            try{
                $products = $elasticSearch->search($group_seo_name, $request['q'], $sort);
                if($request->ajax()){
                    return view('ajax.ajax',[
                        'products' => $products,
                        'group' => $group,
                        "images"=> ProductImage::all(),
                    ])->render();
                }
            }catch(\Exception $exception){
                return response()->view('errors.404',[
                    'user' => $this->getUser(),
                    'cart' => isset($cart) && !empty($cart) ? $cart : null,
                ]);
            }
        }else{
            try{
                $products = $elasticSearch->search($group_seo_name, $request['q']);
                if($request->ajax()){
                    return view('ajax.ajax',[
                        'products' => $products,
                        'group' => $group,
                        "images"=> ProductImage::all(),
                    ])->render();
                }
            }catch(\Exception $exception){
                return response()->view('errors.404',[
                    'user' => $this->getUser(),
                    'cart' => isset($cart) && !empty($cart) ? $cart : null,
                ]);
            }

        }


        return view($view, [
            'user' => $this->getUser(),
            'products' => isset($products) ? $products : null,
            'group' =>  $group,
            'brands' => $group_brands,
            'group_categories' => $group->categories,
            'category' => isset($category) ? $category : null,
            'colors' => ProductColor::where('active', 1)->get(),
            "materials"=> ProductMaterial::where('active', 1)->get(),
            "seasons" => ProductSeason::where('active', 1)->get(),
            "sizes" => ProductSize::where('active', 1)->get(),
            "images"=> ProductImage::all(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
        ]);



    }


    public function filtersRequest(Request $request, ElasticSearch $elasticSearch){

        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }

        //explode query string

        $mainQueryString = explode('?', request()->getRequestUri());
        $arrSeoNames = explode('/', $mainQueryString[0]); // start from 2

        $promotion = false;
        if($arrSeoNames[1] == 'promotions'){
            $promotion = true;
            $promotionBanner = Banner::where('seo_name', $arrSeoNames[3])->where('active', 1)->first();
            $group = CategoryGroup::where('seo_name',$arrSeoNames[2])->where('active', 1)->first();
            $group_brands = $this->getGroupBrand($group->id);

        }else{

            $group = CategoryGroup::where('seo_name',$arrSeoNames[2])->where('active', 1)->first();
            $group_brands = $this->getGroupBrand($group->id);
            if(isset($arrSeoNames[3])){
                $category =  Category::where('seo_name',$arrSeoNames[3])->where('active', 1)->first();
            }
            if(isset($arrSeoNames[4])){
                $subCategory =  SubCategory::where('seo_name',$arrSeoNames[4])->where('active', 1)->first();
            }
        }



        //  --------------------------------------- сама фильтрация, собственно ------------------------------------------

        $arData = [];

        //Эластик лучше всего находит цифры, соотв. нужны айдишники
        $filterType = 'must';
        if(isset($request['colors'])){
            $requestColors = explode(' ', $request['colors']);
            $colors = [];
            foreach ($requestColors as $rc){
               $colorModel = ProductColor::where('seo_name', $rc)->where('active', 1)->first();
               array_push($colors, $colorModel->id );
            }
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'pc_id' => $colors
                ]
            ];
        }
        if(isset($request['brands'])){
            $requestBrands =  explode(' ', $request['brands']);
            $brands = [];
            foreach ($requestBrands as $rb){
                $brandModel = ProductBrand::where('seo_name', $rb)->where('active', 1)->first();
                array_push($brands, $brandModel->id );
            }
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'pb_id' => $brands
                ]
            ];
        }
        if(isset($request['seasons'])){
            $requestSeasons =  explode(' ', $request['seasons']);
            $seasons = [];
            foreach ($requestSeasons as $rs){
                $seasonModel = ProductSeason::where('seo_name', $rs)->where('active', 1)->first();
                array_push($seasons, $seasonModel->id );
            }
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'ps_id' => $seasons
                ]
            ];
        }
        if(isset($request['materials'])){
            $filterType = 'must';
            $requestMaterials =  explode(' ', $request['materials']);
            $materials = [];
            foreach ($requestMaterials as $rm){
                $materialModel = ProductMaterial::where('seo_name', $rm)->where('active', 1)->first();
                array_push($materials, $materialModel->id );
            }
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'pm_id' => $materials
                ]
            ];
        }
        if(isset($request['sizes'])){
            $filterType = 'must';
            $requestSizes  =  explode(' ', $request['sizes']);
            $sizes = [];
            foreach ($requestSizes as $rsize){
                $sizeModel = ProductSize::where('seo_name', $rsize)->where('active', 1)->first();
                array_push($sizes, $sizeModel->id );
            }
            $arData["bool"][$filterType][] =  [
                'terms' => [
                    'psize_id' => $sizes
                ]
            ];
        }

        if(isset($request['priceFrom']) && isset($request['priceTo'])){
            $filterType = 'must';

            // и такое может случиться: пользователь полез
            // в строку запроса и поставил пробел в числе фильтра цены

            $requestPriceFrom = explode(' ', $request['priceFrom']);
            $requestPriceTo = explode(' ', $request['priceTo']);
            if(count($requestPriceFrom) > 1){
                $priceFrom = $requestPriceFrom[0];
            }else{
                $priceFrom = $request['priceFrom'];
            }
            if(count($requestPriceTo) > 1){
                $priceTo = $requestPriceTo[0];
            }else{
                $priceTo = $request['priceTo'];
            }
            $arData["bool"][$filterType][] =  [
                'range' => [
                    'price' => [
                        "gte" => $priceFrom,
                        "lte" => $priceTo
                    ]
                ]
            ];
        }


        $seo_names = [empty($group) ? "" :$group->seo_name, !isset($category) ? "" : $category->seo_name, !isset($subCategory) ? "" : $subCategory->seo_name];

        // определение всех ..категорий.. и вьюх
        // в соответствии которым отдавать конкретные продукты

            if($seo_names[0] != "women" && $seo_names[0] != "men" && $seo_names[0] != "girls" && $seo_names[0] != "boys"){
                $must = ['match' => ['cg_seo_name' => "women"]];
                $view = 'index';
                $banners = Banner::where('active', 1)->get();
            }else{

                //Эластик лучше всего находит цифры, соотв. нужны айдишники

                if($promotion){
                    if($seo_names[0] != "") {
                        $must = [
                            ['match' => ['cg_seo_name' => $seo_names[0]]],
                            ['match' => ['banner_id' => $promotionBanner->id]],
                        ];
                        $view = 'promotions.index';
                    }
                }else{
                    if($seo_names[0] != "" && $seo_names[1] == "" && $seo_names[2] == ""){
                        $must = [
                            ['match' => ['cg_seo_name' => $seo_names[0]]],
                        ];
                        $view = 'index';
                        $banners = Banner::where('active', 1)->where('category_group_id', $group->id)->get();
                    }
                    if($seo_names[0] != "" && $seo_names[1] != "" && $seo_names[2] == ""){
                        $cg = CategoryGroup::where('seo_name',$seo_names[0] )->where('active', 1)->first();
                        $c = Category::where('seo_name', $seo_names[1] )->where('active', 1)->first();
                        $must = [
                            ['match' => ['product_category_group' => $cg->id]],
                            ['match' => ['product_category' => $c->id]]
                        ];
                        $view = 'category.category';
                    }
                    if($seo_names[0] != "" && $seo_names[1] != "" && $seo_names[2] != ""){
                        $cg = CategoryGroup::where('seo_name',$seo_names[0] )->where('active', 1)->first();
                        $c = Category::where('seo_name', $seo_names[1] )->where('active', 1)->first();
                        $sc = SubCategory::where('seo_name', $seo_names[2] )->where('active', 1)->first();
                        $must = [
                            ['match' => ['product_category_group' => $cg->id]],
                            ['match' => ['product_category' => $c->id]],
                            ['match' => ['product_category_sub' => $sc->id]]
                        ];
                        $view = 'SubCategory.subcategory';
                    }
                }

            }

        if(isset($request['orderBy'])){
            //dd($arData);
            $sort = $request['orderBy'];
            try{
                $products = $elasticSearch->searchByFilters($must, $arData, $sort);

                if($request->ajax()){
                    return view('ajax.ajax',[
                        'products' => $products,
                        'group' => $group,
                        "images"=> ProductImage::all(),
                    ])->render();
                }
            }catch(\Exception $exception){
                return response()->view('errors.404',[
                    'user' => $this->getUser(),
                    'cart' => isset($cart) && !empty($cart) ? $cart : null,
                ]);
            }
        }else{
            //dd($arData);
            try{
                $products = $elasticSearch->searchByFilters($must, $arData);

                if($request->ajax()){
                    return view('ajax.ajax',[
                        'products' => $products,
                        'group' => $group,
                        "images"=> ProductImage::all(),
                    ])->render();
                }
            }catch(\Exception $exception){
                return response()->view('errors.404',[
                    'user' => $this->getUser(),
                    'cart' => isset($cart) && !empty($cart) ? $cart : null,
                ]);
            }
        }


        return view( $view, [
            'user' => $this->getUser(),
            'banners' => isset($banners) ? $banners : null,
            'banner' => isset($promotionBanner) && !empty($promotionBanner) ? $promotionBanner : null,
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
            'group' =>  $group,
            'group_categories' => $group->categories,
            'products' => $products,
            'brands' => $group_brands,
            'category' => isset($category) &&  !empty($category) ? $category : null,
            'sub_category' => isset($subCategory) &&  !empty($subCategory) ? $subCategory : null,
            'colors' => ProductColor::where('active', 1)->get(),
            "materials"=> ProductMaterial::where('active', 1)->get(),
            "seasons" => ProductSeason::where('active', 1)->get(),
            "sizes" => ProductSize::where('active', 1)->get(),
            "images"=> ProductImage::all(),

        ]);
    }
}
