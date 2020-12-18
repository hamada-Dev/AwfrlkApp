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
        if (auth()->user()->group == 'delivery')
            return $next($request);
        else
            return response(['data' => 'not allow to access ', 'state' => '405'], 405);
    }
}
