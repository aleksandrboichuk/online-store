<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderListItem;
use App\Models\OrdersList;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout($user_id){
        $user_cart = Cart::where("user_id",$user_id)->first();
        return view('checkout.checkout',[
            'user' =>$this->getUser(),
            'products' => $user_cart->products,
        ]);
    }

    public  function saveOrder(Request $request){
        $cart = Cart::where('user_id', $this->getUser()->id)->first();
        $totalSum = 0;
        for ($i = 0; $i < count($cart->products); $i++ ){
            $totalSum += $cart->products[$i]->pivot->count *  $cart->products[$i]['price'];
        }

        $ordersList = OrdersList::create([
            "user_id"=> $this->getUser()->id,
            "name" => $this->getUser()->first_name . ' ' . $this->getUser()->last_name,
            "email"=> $this->getUser()->email,
            "phone"=> $this->getUser()->phone,
            "address"=> $this->getUser()->address,
            "comment"=> $request['comment'],
            "total_cost" => $totalSum
        ]);

//        $ordersLists = OrdersList::where('user_id',$this->getUser()->id)->first();
        foreach ($cart->products as $product){
            $ordersList->items()->create([
                "order_id" =>  $ordersList->id,
                "product_id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "count" => $product->pivot->count,
                "total_cost" => $product->price * $product->pivot->count
            ]);

        }
        return redirect('/women');
    }
}
