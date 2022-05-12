<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentManagerRoleCheck
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
        $user = Auth::user();
        if(!empty($user->roles) && count($user->roles ) > 0){
            $is_role = false;
            foreach ( $user->roles as $role) {
                if($role->seo_name == 'content-manager' || $role->seo_name == 'main-admin'){
                    $is_role = true;
                    break;
                }
            }
            $is_role ?: abort(403);
        }else{
            return redirect('/');
        }
        return $next($request);
    }
}
