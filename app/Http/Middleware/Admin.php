<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (auth()->guest()) {
            return redirect('/login');
        } else if (auth()->user()->group == 'admin' && auth()->user()->delivery_status != 3 ) {
            return $next($request);
        } else {
            return redirect('/login');
        }

        // if(auth()->guest()){
        //     return redirect('/login');
        // }
        // else if(auth()->user()->group == 'user'){
        //     return redirect()->back();
        // }
        // return $next($request);
    }
}
