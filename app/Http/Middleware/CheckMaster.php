<?php

namespace App\Http\Middleware;

use Closure;

class CheckMaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检查登录用户的角色身份
        if (\Auth::user()->hasRole('master')) {
            return $next($request);
        }
        return redirect('home');
    }
}
