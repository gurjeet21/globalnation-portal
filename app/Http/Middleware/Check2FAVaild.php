<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Check2FAVaild
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

        // if(\DB::table('users')->where('id',\Auth::id())->where('2fa_now',1)->exists()){
        //     return $next($request);
        // }else{
        //     \Auth::logout();
        //     return redirect()->to(route('login'));
        // }
    }

    

}
