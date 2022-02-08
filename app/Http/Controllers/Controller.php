<?php

namespace App\Http\Controllers;

use App\Models\ProductBrand;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
        return $group_brands;
    }


}
