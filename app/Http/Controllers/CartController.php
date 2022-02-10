<?php

namespace App\Http\Controllers;

use App\Models\Cart;

use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function showUserCart(Request $request, $user_id){
        $user_cart = Cart::where("user_id",$user_id)->first();

        if(!empty($request->value) && !empty($request->updateId)) {
            $product = $user_cart->products()->where("product_id",$request->updateId)->first();
            $product->carts()->update(["count" => $request->value]);
            if($request->ajax()){
                return view('ajax.ajax-cart',[
                    'user' =>$this->getUser(),
                    'products' => $user_cart->products
                ])->render();
            }
        }

        if(!empty($request->deleteId)) {
            $user_cart->products()->detach($request->deleteId);
            if($request->ajax()){
                return view('ajax.ajax-cart',[
                'user' =>$this->getUser(),
                'products' => $user_cart->products
            ])->render();
            }
        }

        return view('cart.cart', [
            'user' =>$this->getUser(),
            'products' => $user_cart->products
        ]);
    }


    public function addToCart(Request $request, $product_id,$user_id){
         $cart = Cart::where('user_id', $user_id)->first();
        $is_product = false;
         for($i = 0; $i < count($cart->products);$i++){
             if ($cart->products[$i]['id'] == $product_id){
                 $product = $cart->products()->where("product_id",$product_id)->first();
                 $product->carts()->update(["count" => $request['quantity']]);
                 $is_product = true;
                 break;
             }
         }
         if(!$is_product){
             $cart->products()->attach($user_id,[
                 'cart_id' => $cart->id,
                 'product_id' => $product_id,
                 'count' =>$request['quantity'],
                 'size' =>22,
             ]);
         }




         return back();

    }
}
