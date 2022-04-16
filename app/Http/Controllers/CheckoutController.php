<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderListItem;
use App\Models\OrdersList;
use App\Models\UkraineCity;
use App\Models\UserPromocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request){
        if(!$this->getUser()){
            $user_cart = $this->getCartByToken();
        }else{
            $user_cart = Cart::where("user_id",$this->getUser()->id)->first();
        }

        // ============================ Если кто то додумается без товаров в корзине пойти на чекаут по урлу ===================================
        if(!isset($user_cart->products) || empty($user_cart->products) || count($user_cart->products) < 1){
           return redirect()->back();
        }

        // =================================  Define total cost  ========================================
        $totalSum = 0;
        for ($i = 0; $i < count($user_cart->products); $i++ ) {
            $productPrice = $user_cart->products[$i]['discount'] != 0
                ? $user_cart->products[$i]['price'] - (round($user_cart->products[$i]['price'] * ($user_cart->products[$i]['discount'] * 0.01)))
                : $user_cart->products[$i]['price'];
            $totalSum += $user_cart->products[$i]->pivot->count * $productPrice;
        }


        if($request['promocode'] != 'no'){
            $allowPromocode = false;
            $promocode = UserPromocode::where('promocode', $request['promocode'])->first();
            if(!empty($promocode->min_cart_total)){
                if($promocode->min_cart_total >  $totalSum){
                    session(
                        [
                            'warning-message' => 'Недостатня сума товарів кошику для застосування обраного вами промокоду. Потрібно не менше  ₴'. $promocode->min_cart_total .'. Спробуйте обрати інший промокод, або додати ще товарів до кошику.'
                        ]);
                    return redirect()->back();
                }else{
                    $allowPromocode = true;
                }
            }
            if(!empty($promocode->min_cart_products)){
                if($promocode->min_cart_products >  count($user_cart->products)){
                    return redirect()->back()->with(
                        [
                            'warning-message' => 'Недостатня кількість товарів кошику для застосування обраного вами промокоду. Потрібно не менше '. $promocode->min_cart_products .'. Спробуйте обрати інший промокод, або додати ще товарів до кошику.'
                        ]
                    );
                }else{
                    $allowPromocode = true;
                }
            }
        }
        return view('checkout.checkout', [
            'cart' => $user_cart,
            'user' =>$this->getUser(),
            'products' => $user_cart->products,
            'totalSum' => $totalSum,
            'promocode' => isset($allowPromocode) && $allowPromocode ? $promocode : null,
            'cities' => UkraineCity::all(),
        ]);
    }

    public  function saveOrder(Request $request){

        if(!$this->getUser()){
            $cart = $this->getCartByToken();
        }else{
            $cart = Cart::where("user_id",$this->getUser()->id)->first();
        }

        // ====================== define total sum  ================
        $totalSum = 0;
        for ($i = 0; $i < count($cart->products); $i++ ){
            $productPrice = $cart->products[$i]['discount'] != 0
                ? $cart->products[$i]['price'] - (round($cart->products[$i]['price'] * ($cart->products[$i]['discount'] * 0.01)))
                : $cart->products[$i]['price'];
            $totalSum += $cart->products[$i]->pivot->count *  $productPrice;
        }

        // ====================== define total sum with promocode ================
        if(isset($request['promocode']) && !empty($request['promocode']) && Auth::check()){
            $promocode = UserPromocode::where('promocode', $request['promocode'])->first();
            if($promocode){
                for ($i = 0; $i < count($cart->products); $i++ ){
                    $totalSum = $totalSum - (round($totalSum * ($promocode->discount * 0.01)));
                }
                // ========================== deleting promocode  ============================
                $this->getUser()->promocodes()->where('user_promocode_id', $promocode->id)->detach();
            }
        }

        // ====================== define delivery ================
        if(isset($request['post-department-field'])){
            $postDepartment = intval($request['post-department-field']);
        }elseif(isset($request['address-field'])){
            $address = $request['address-field'];
        }
        if(isset($request['email-field'])){
            $email = $request['email-field'];
            $payNow = true;
        }else{
            $payNow = false;
        }

        if(!$this->getUser()) {
            try{
                $ordersList = OrdersList::create([
                    "token"=> session('_token'),
                    "name" =>$request['user-firstname'] . ' ' . $request['user-lastname'],
                    "email"=> isset($email) ? $email : null,
                    "pay_now"=> $payNow,
                    "phone"=> $request['user-phone'],
                    "city"=> $request['user-city'],
                    "address"=> isset($address) ? $address : null,
                    "post_department"=> isset($postDepartment) ? $postDepartment :  null,
                    "comment"=> $request['comment'],
                    "total_cost" => $totalSum,
                ]);
            }catch(\Exception $e){
                return response()->json(['Adding new order error: ' . $e->getMessage()]);
            }

        }else{
            try{
                $ordersList = OrdersList::create([
                    "user_id"=> $this->getUser()->id,
                    "name" =>$request['user-firstname'] . ' ' . $request['user-lastname'],
                    "email"=> isset($email) ? $email : null,
                    "pay_now"=> $payNow,
                    "phone"=> $request['user-phone'],
                    "city"=> $request['user-city'],
                    "address"=> isset($address) ? $address : null,
                    "post_department"=> isset($postDepartment) ? $postDepartment :  null,
                    "comment"=> $request['comment'],
                    "total_cost" => $totalSum,
                    "promocode" => isset($request['promocode']) && !empty($request['promocode']) ? $request['promocode'] : null,
                ]);
            }catch(\Exception $e){
                return response()->json(['Adding new order error: ' . $e->getMessage()]);
            }
        }

        try{
            foreach ($cart->products as $product){
                $productPrice =  $product->discount != 0 ? $product->price - (round($product->price * ($product->discount * 0.01))) : $product->price;
                $ordersList->items()->create([
                    "order_id" =>  $ordersList->id,
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "price" => $productPrice,
                    "count" => $product->pivot->count,
                    "total_cost" => $productPrice * $product->pivot->count,
                    "size" => $product->pivot->size,
                ]);

            }
        }catch(\Exception $e){
            return response()->json(['Adding products to new order error: ' . $e->getMessage()]);
        }

//        foreach ($cart->products as $product) {
//            $product->update([
//                "count" => $product->count -
//            ]);
//            $product->pivot->delete();
//        }

        foreach ($cart->products as $product) {
            $product->pivot->delete();
        }

        if(!$this->getUser()){
            return redirect('/cart')->with(
                ['success-message' => 'Ви успішно виконали замовлення. У найближчий час з вами зв\'яжеться адміністратор для уточнення деталей.']
            );
        }else{

            return redirect('/personal/orders')->with(
                ['success-message' => 'Ви успішно виконали замовлення. У найближчий час з вами зв\'яжеться адміністратор для уточнення деталей.']
            );
        }


    }
}
