<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class MultiViewMiddleware
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
        if (!Auth::guard('admin')->check() && !Auth::guard('web')->check()){
            return redirect()->route('main');
        }
        return $next($request);
    }
}
