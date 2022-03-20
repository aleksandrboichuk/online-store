<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppAuth
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
        if($request->getRequestUri() == '/login' || $request->getRequestUri() == '/register' ){
            if (Auth::check()) {
                return redirect('/personal/orders');
            }
        }elseif(preg_match('#^\/admin#',$request->getRequestUri())){
            if (Auth::check()) {
                $user = User::find(Auth::id());
                if (!$user->superuser) {
                    return redirect('/shop/women');
                }
            }else{
                return redirect('/login');
            }
        }
        return $next($request);
    }
}
