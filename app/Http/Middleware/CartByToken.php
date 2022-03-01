<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartByToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            $cart = Cart::where('token', session('_token'))->first();
            if(!$cart){
                 Cart::create([
                    'token' => session('_token')
                ]);
            }else{
                if($cart->created_at < date('Y-m-d H:i:s', strtotime('-5 hours'))){
                    $cart->delete();
                }
            }

        }
        return $next($request);
    }
}
