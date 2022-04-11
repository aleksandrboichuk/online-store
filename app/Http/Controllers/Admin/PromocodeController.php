<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\UserPromocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function index()
    {
        $promocodes = UserPromocode::orderBy('id', 'desc')->paginate(5);

        if(request()->ajax()){
            return view('admin.promocode.ajax.ajax-pagination', [
                'promocodes' => $promocodes,
            ])->render();
        }

        return view('admin.promocode.index',[
            'user'=>$this->getUser(),
            'promocodes' => $promocodes,

        ]);
    }

    //show adding form

    public function addPromocode(){

        return view('admin.promocode.add',[
            'user'=>$this->getUser(),
        ]);
    }

    //saving add

    public function saveAddPromocode(Request $request){
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        UserPromocode::create([
            'title' => $request['title-field'],
            'description' => $request['description-field'],
            'discount' => $request['discount-field'],
            'min_cart_total' => !empty( $request['min-cart-total-field']) &&  $request['min-cart-total-field'] != '0' ?  $request['min-cart-total-field'] : null,
            'min_cart_products' =>  !empty( $request['min-cart-products-field']) &&  $request['min-cart-products-field'] != '0' ?  $request['min-cart-products-field'] : null,
            'promocode' => $request['promocode-field'],
            'active' => $active,
        ]);
        session(['success-message' => 'Промокод успішно додано.']);
        return redirect('/admin/promocode');
    }

    //editing

    public function editPromocode($promocode_id){
        $promocode = UserPromocode::find($promocode_id);

        if(!$promocode){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.promocode.edit',[
            'user' => $this->getUser(),
            'promocode' => $promocode ,
        ]);
    }


    //saving edit

    public function saveEditPromocode(Request $request){

        $promocode = UserPromocode::find($request['id']);
        if(!$promocode){
            if($this->getUser()){
                $cart = Cart::where('token', session('_token'))->first();
            }
            return response()->view('errors.404', ['user' => $this->getUser(), 'cart' => isset($cart) ? $cart : null ], 404);
        }
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $promocode->update([
            'title' => $request['title-field'],
            'description' => $request['description-field'],
            'discount' => $request['discount-field'],
            'min_cart_total' => isset( $request['min-cart-total-field']) &&  $request['min-cart-total-field'] != '0' ?  $request['min-cart-total-field'] : null,
            'min_cart_products' =>  isset( $request['min-cart-products-field']) &&  $request['min-cart-products-field'] != '0' ?  $request['min-cart-products-field'] : null,
            'promocode' => $request['promocode-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        session(['success-message' => 'Промокод успішно змінено.']);
        return redirect("/admin/promocode");
    }

    //delete

    public function delPromocode($promocode_id){
        $promocode = UserPromocode::find($promocode_id);

        $promocode->delete();

        session(['success-message' => 'Промокод успішно видалено.']);
        return redirect("/admin/promocode");
    }
}
