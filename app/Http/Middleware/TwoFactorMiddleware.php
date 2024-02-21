<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorMiddleware
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

        $is_2fa_enable  = \Auth::user()->is_2fa_enable;
        $two_fa_now = \Auth::user()->two_fa_now;
        if($is_2fa_enable != 1){
            return redirect()->route('twoFa');
        }

        if($is_2fa_enable == 1 && $two_fa_now != 1){
            \Auth::logout();
            return redirect()->to(route('login'));
        }

        return $next($request);

    }
}
