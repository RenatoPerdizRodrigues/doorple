<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Config;
use Auth;

class CheckConfig
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
     
            /*Redireciona o admin a página de configuração de sistema caso o mesmo não esteja configurado, 
            e desloga usuário caso o mesmo esteja logado sem o sistema estar configurado*/
            $config = Config::all()->first();
            if (Auth::guard('admin')->check()){
                if ($config == null || $config->configured == 0){
                    Session::flash('success', 'O sistema deve ser configurado antes de sua utilização!');
                    return redirect()->route('admin.config1');
                }
            } elseif (Auth::guard('web')->check()){
                if ($config == null || $config->configured == 0){
                    Session::flash('success', 'O sistema deve ser configurado antes de sua utilização!');
                    return redirect()->route('logout');
                }
            }            

        return $next($request);
    }
}
