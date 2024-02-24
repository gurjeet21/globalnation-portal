<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
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
        $user = auth()->user();
        if($user->role == "Super Admin1"){
            return $next($request);
        }else{
            $user_role =  $user->role;
            $user_permission = config('constants.roles')[$user->role];
            $route = \Request::route()->getName();
            if (in_array($route, $user_permission)){
                return $next($request);
            }else{
                abort(404);
            }          
        }
       
    }
}
