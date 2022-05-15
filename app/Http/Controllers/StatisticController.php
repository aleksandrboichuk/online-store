<?php

namespace App\Http\Controllers;

use App\Models\OrderListItem;
use App\Models\OrdersList;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request){
       if(isset($request->date_start) && trim($request->date_start) != ''
           && isset($request->date_finish) && trim($request->date_finish) != ''){
           $d1 = strtotime($request->date_start);
           $d2 = strtotime($request->date_finish); // переводит из строки в дату
           $date_start = date("Y-m-d", $d1); // переводит в новый формат
           $date_finish = date("Y-m-d", $d2);

           $users = User::whereBetween('created_at', [$date_start,  $date_finish])->get();
           $registeredUsers = count($users) > 0 ? count($users) : 0;
            //orders
           $status = false;
           $orders = OrdersList::whereBetween('created_at', [$date_start,  $date_finish])->get();

           if(!empty($orders) && count($orders) > 0){
               $status = true;
               $arProductsID = [];
               $total = 0;
               foreach ($orders as $order) {
                   $total += $order->total_cost;
                   $order_items = OrderListItem::where('order_id', $order->id)->get();
                   foreach ($order_items as $item) {
                       $arProductsID[] = $item->product_id;
                   }
               }
                $arProductsID_unique = array_unique($arProductsID);
               $arPopularity = [];
               foreach ($arProductsID_unique as $ar_u) {
                   $popularity_count = 0;
                   foreach ($arProductsID as $ar) {
                       if($ar_u == $ar){
                           $popularity_count ++;
                       }
                    }
                   $arPopularity[$ar_u] = $popularity_count;
               }

              $products = Product::findMany( $this->popularityProducts($arPopularity));
               if(!$products){
                   $status = false;
               }
           }

            if(!$status){
                if($request->ajax()){
                    return view('admin.statistic.ajax', [
                        'status' => false
                    ])->render();
                }
            }else{
                if($request->ajax()){
                    return view('admin.statistic.ajax', [
                        'status' => true,
                        'orders_amount' => count($orders),
                        'total' => $total,
                        'registeredUsers' => $registeredUsers,
                        'products' => $products,
                    ])->render();
                }
            }

       }

        return view('admin.statistic.index', [
            'user' => $this->getUser(),

        ]);
    }

   protected function popularityProducts($arPopularity){
      $i = 0;
      $arPopularityProducts = [];
       while($i < count($arPopularity)){
          $arPopularity_max = max($arPopularity);
          foreach ($arPopularity as $key => $value) {
              if($value == $arPopularity_max){
                  $arPopularityProducts[] = $key;
                  unset($arPopularity[$key]);
                  break;
              }
          }
          $i++;
      }
      return $arPopularityProducts;
   }
}
