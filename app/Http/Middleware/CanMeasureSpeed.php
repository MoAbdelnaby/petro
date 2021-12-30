<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CanMeasureSpeed
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
        if (Auth::user()->speedtest == 1 && Auth::user()->type != 'customer' ) {

            return redirect()->route('branch.register');
        }
        return $next($request);
    }
}
