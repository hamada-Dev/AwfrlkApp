<?php

namespace App\Http\Middleware;

use Closure;

class GroupDelivery
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
        if (auth()->user()->group == 'delivery') {
            if (auth()->user()->delivery_status !=  3)
                return $next($request);
            else
                return response(['data' => 'you are in BLACK LIST ', 'state' => '200'], 200);
        } else {
            return response(['data' => 'not allow to access ', 'state' => '200'], 200);
        }
    }
}
