<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Request;
use Response;
use Illuminate\Auth\AuthenticationException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    //Sobrescrição da função de redirecionamento para usuários não autenticados, para a tela de login correta
    public function unauthenticated($request, AuthenticationException $exception){
        //Checa qual guard fez a request de login
        $guard = array_get($exception->guards(), 0);

        //Verifica para onde redirecionar o usuário
        switch ($guard){
            case 'admin':
            $login = 'admin.login';
            break;

            default:
            $login = 'login';
            break;
        }

        //Redireciona para a página de login adequada
        return redirect()->guest(route($login));
    }
}
