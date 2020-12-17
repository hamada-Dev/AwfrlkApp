<?php

namespace App\Http\Middleware;

use Closure;

class PhoneVerified
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
        if(auth()->user()->isVerified == 0){
            return redirect()->route('verify_phone');
        }
        return $next($request);
    }
}
