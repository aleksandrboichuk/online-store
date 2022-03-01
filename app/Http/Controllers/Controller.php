<?php

namespace App\Http\Controllers;

use App\Models\ProductBrand;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUser(){
        if(Auth::check()){
            return Auth::user();
        }else{
            return null;
        }

    }

    public function getGroupBrand($group_id){
        $brands = ProductBrand::all();
        foreach ($brands as $brand) {
            foreach ($brand->products as $brand_product){
                if($brand_product->category_group_id == $group_id){
                    $group_brands[] = $brand;
                    break;
                }
            }
        }
        if(isset($group_brands)){
            return $group_brands;
        }else{
            return  null ;
        }

    }


}
