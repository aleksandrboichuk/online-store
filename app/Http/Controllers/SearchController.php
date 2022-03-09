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
    public function index($group_seo_name,Request $request, ElasticSearch $elasticSearch){
        $group = CategoryGroup::where('seo_name', $group_seo_name)->first();

        $view = 'search.cg-search';
        $group_brands = $this->getGroupBrand($group->id);
        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }

        if(isset($request['orderBy'])){
            $sort = $request['orderBy'];
            $products = $elasticSearch->search($group_seo_name, $request['q'], $sort);
        }else{
            $products = $elasticSearch->search($group_seo_name, $request['q']);
        }


        return view($view, [
            'user' => $this->getUser(),
            'products' => isset($products) ? $products : null,
            'group' =>  $group,
            'brands' => $group_brands,
            'group_categories' => $group->categories,
            'category' => isset($category) ? $category : null,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
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

        $group = CategoryGroup::where('seo_name',$arrSeoNames[2])->first();
        $group_brands = $this->getGroupBrand($group->id);


        if(isset($arrSeoNames[3])){
            $category =  Category::where('seo_name',$arrSeoNames[3])->first();
        }
        if(isset($arrSeoNames[4])){
            $subCategory =  SubCategory::where('seo_name',$arrSeoNames[4])->first();
        }



        //гибкость фильтрации (если понадобится)

        //        $colorFilterType = 'must';
//        $brandFilterType = 'must';
//        if(isset($request['colors']) && !empty($request['colors']) && isset($request['brands']) && !empty($request['brands'])) {
//            $requestBrandsFilters = explode(' ', $request['brands']);
//            $requestColorsFilters = explode(' ', $request['colors']);
//            if(count($requestBrandsFilters) > 1 || count($requestColorsFilters) == 1) {
//                $filterType = 'filter';
//            } else {
//                $filterType = 'must';
//            }
//        } else {
//
//        }

        //  --------------------------------------- сама фильтрация, собственно ------------------------------------------

        $arData = [];

        //Эластик лучше всего находит цифры, соотв. нужны айдишники
        $filterType = 'must';
        if(isset($request['colors'])){
            $requestColors = explode(' ', $request['colors']);
            $colors = [];
            foreach ($requestColors as $rc){
               $colorModel = ProductColor::where('seo_name', $rc)->first();
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
                $brandModel = ProductBrand::where('seo_name', $rb)->first();
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
                $seasonModel = ProductSeason::where('seo_name', $rs)->first();
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
                $materialModel = ProductMaterial::where('seo_name', $rm)->first();
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
                $sizeModel = ProductSize::where('seo_name', $rsize)->first();
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

                if($seo_names[0] != "" && $seo_names[1] == "" && $seo_names[2] == ""){
                    $must = [
                        ['match' => ['cg_seo_name' => $seo_names[0]]],
                    ];
                    $view = 'index';
                    $banners = Banner::where('active', 1)->get();
                }
                if($seo_names[0] != "" && $seo_names[1] != "" && $seo_names[2] == ""){
                    $cg = CategoryGroup::where('seo_name',$seo_names[0] )->first();
                    $c = Category::where('seo_name', $seo_names[1] )->first();
                    $must = [
                        ['match' => ['product_category_group' => $cg->id]],
                        ['match' => ['product_category' => $c->id]]
                    ];
                    $view = 'category.category';
                }
                if($seo_names[0] != "" && $seo_names[1] != "" && $seo_names[2] != ""){
                    $cg = CategoryGroup::where('seo_name',$seo_names[0] )->first();
                    $c = Category::where('seo_name', $seo_names[1] )->first();
                    $sc = SubCategory::where('seo_name', $seo_names[2] )->first();
                    $must = [
                        ['match' => ['product_category_group' => $cg->id]],
                        ['match' => ['product_category' => $c->id]],
                        ['match' => ['product_category_sub' => $sc->id]]
                    ];
                    $view = 'SubCategory.subcategory';
                }
            }

        if(isset($request['orderBy'])){
            //dd($arData);
            $sort = $request['orderBy'];
            $products = $elasticSearch->searchByFilters($must, $arData, $sort);

        }else{
            //dd($arData);
            $products = $elasticSearch->searchByFilters($must, $arData);
        }


        return view( $view, [
            'user' => $this->getUser(),
            'banners' => isset($banners) ? $banners : null,
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
            'group' =>  $group,
            'group_categories' => $group->categories,
            'products' => $products,
            'brands' => $group_brands,
            'category' => isset($category) &&  !empty($category) ? $category : null,
            'sub_category' => isset($subCategory) &&  !empty($subCategory) ? $subCategory : null,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
            "images"=> ProductImage::all(),

        ]);


    }
}
