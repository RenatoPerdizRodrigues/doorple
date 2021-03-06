<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //Verifica para onde redirecionar usuários já logados
        switch ($guard){
            case 'admin';
            if (Auth::guard('admin')->check()){
                return redirect()->route('admin.dashboard');
            }
            break;

            default:
            if (Auth::guard('web')->check()){
                return redirect('/home');
            }
            break;

        }

        return $next($request);
    }
}
