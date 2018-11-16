<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Rota para usuários logados, a trabalhar
Route::get('/', 'HomeController@main')->name('main');

//Rotas de autenticação de usuário
Auth::routes();
Route::get('/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::get('/home', 'HomeController@index')->name('home');

//Rotas relacionadas ao administrador, com prefix admin
Route::prefix('admin')->group(function(){
    //Rotas para login, logout e página principal de admin
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
    Route::get('/', 'AdminController@home')->name('admin.dashboard');

    //Rotas para envio de e-mail de resetar a senha de administrador
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    //Rotas para a troca efetiva da senha de administrador
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');

    //Rotas para configuração do sistema
    Route::get('/config/index', 'ConfigController@index')->name('admin.config.index');
    Route::post('/config/index', 'ConfigController@search')->name('admin.config.search.submit');
    Route::get('/config', 'ConfigController@config')->name('admin.config');
    Route::post('/config', 'ConfigController@startConfig')->name('admin.config.submit');
    Route::get('/config/ap', 'ConfigController@apIndex')->name('admin.config.ap');
    Route::get('/config/ap/2', 'ConfigController@apDetail')->name('admin.config.ap.detail');
    Route::get('/config/ap/3', 'ConfigController@apDetail2')->name('admin.config.ap.detail2');
    Route::post('/config/ap', 'ConfigController@finishConfig')->name('admin.config.finish');
    Route::get('/config/edit', 'ConfigController@edit')->name('admin.config.edit');

    //Rotas para cadastro de novos administradores, usuários, moradores e veículos
    Route::prefix('register')->group(function(){
        //Rota para função de pesquisa que mostra um admin específico
        Route::post('/adm/search', 'AdminController@search')->name('adm.search.submit');
        //Rota para a visualização do formulário de exclusão do admin
        Route::get('/adm/delete/{id}', 'AdminController@delete')->name('admin.delete');
        //Rotas gerais do CRUD de admin, através do resource
        Route::resource('/adm', 'AdminController');

        //Rota para função de pesquisa que mostra um admin específico
        Route::post('/usr/search', 'UserController@search')->name('usr.search.submit');
        //Rota para a visualização do formulário de exclusão do usuário
        Route::get('/usr/delete/{id}', 'UserController@delete')->name('usr.delete');
        //Rotas gerais do CRUD de usuário, através do resource
        Route::resource('/usr', 'UserController');
    });

    //Rota para função de pesquisa que mostra um morador específico
    Route::post('/morador/search', 'MoradorController@search')->name('morador.search.submit');
    //Rota para a visualização do formulário de exclusão do morador
    Route::get('/morador/delete/{id}', 'MoradorController@delete')->name('morador.delete');
    //Rotas para criação de novos moradores
    Route::resource('morador', 'MoradorController');

    //Rota para função de pesquisa que mostra um veículo de morador específico
    Route::post('/veiculo_morador/search', 'Veiculo_MoradorController@search')->name('veiculo_morador.search.submit');
    //Rota para a visualização do formulário de exclusão do veículo de morador
    Route::get('/veiculo_morador/delete/{id}', 'Veiculo_MoradorController@delete')->name('veiculo_morador.delete');
    //Rota para a criação de um veículo atrelado a um ID de morador
    Route::get('/veiculo_morador/create/{id}', 'Veiculo_MoradorController@create')->name('veiculo_morador.create');
    //Rotas para criação de novos veículos de moradores
    Route::resource('veiculo_morador', 'Veiculo_MoradorController')->except(['create']);
    
});