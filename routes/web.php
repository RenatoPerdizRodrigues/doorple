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
Route::get('/home', 'HomeController@index')->name('user.dashboard');

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
    Route::get('/config/1', 'ConfigController@config1')->name('admin.config1');
    Route::post('/config/1', 'ConfigController@config1Save')->name('admin.save.config1');
    Route::get('/config/2', 'ConfigController@config2')->name('admin.config2');
    Route::post('/config/2', 'ConfigController@config2Save')->name('admin.save.config2');
    Route::get('/config/3', 'ConfigController@config3')->name('admin.config3');
    Route::post('/config/3', 'ConfigController@config3Post')->name('admin.config3Post');
    Route::post('/config/finish', 'ConfigController@config3Save')->name('admin.save.config3');


    Route::get('/config/index/{prefix?}', 'ConfigController@index')->name('admin.config.index');
    Route::post('/config/index/{prefix?}', 'ConfigController@search')->name('admin.config.search.submit');
    Route::get('/config/edit', 'ConfigController@edit')->name('admin.config.edit');
    Route::put('/config/edit', 'ConfigController@update')->name('admin.config.update');
    Route::get('/config/create', 'ConfigController@create')->name('admin.config.create');
    Route::post('/config/create', 'ConfigController@store')->name('admin.config.store');
    Route::get('config/delete/{id}', 'ConfigController@delete')->name('admin.config.delete');
    Route::delete('config/delete/{id}', 'ConfigController@destroy')->name('admin.config.destroy');
    Route::get('/config/ap_edit/{id}', 'ConfigController@apEdit')->name('admin.config.ap-edit');
    Route::put('/config/ap_edit/{id}', 'ConfigController@apUpdate')->name('admin.config.ap-update');

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

    //Rotas de Usuário
    //Rota para criação de visitante
    Route::get('/visitante/main', 'VisitanteController@main')->name('vst.main');
    Route::post('/visitante/search', 'VisitanteController@search')->name('vst.search.submit');
    Route::get('/visitante/show/{id}', 'VisitanteController@show')->name('vst.show');
    Route::post('/visitante/find', 'VisitanteController@find')->name('vst.find.submit');
    Route::get('/visitante/create/{rg}/{blocovisita}/{apartamentovisita}', 'VisitanteController@create')->name('vst.create');
    Route::get('/visitante/delete/{id}', 'VisitanteController@delete')->name('vst.delete');
    Route::resource('/visitante', 'VisitanteController', [
        'names' => [
            'store' => 'vst.store',
            'index' => 'vst.index',
            'update' => 'vst.update',
            'destroy' => 'vst.destroy',
            'edit' => 'vst.edit'
        ]
        ])->except('create');

    //Rotas para criação de visita
    Route::get('/visita/create/{id}/{apartamento}/{bloco}/{placa?}/{modelo?}', 'VisitaController@create')->name('visita.create');
    //Rota de Index de visita
    Route::post('/visita/search', 'VisitaController@search')->name('visita.search.submit');
    Route::get('visita/index/{date?}', 'VisitaController@index')->name('visita.index');
    Route::post('visita/index', 'VisitaController@leave')->name('visita.leave');
    Route::resource('/visita', 'VisitaController')->except('create', 'index');

    //Rotas para criação de entrada de morador
    Route::post('/entrada/confirm', 'EntradaMoradorController@confirm')->name('entrada.confirm');
    Route::post('/entrada/index', 'EntradaMoradorController@search')->name('entrada.search.submit');
    Route::get('/entrada/index/{date?}', 'EntradaMoradorController@index')->name('entrada.index');
    Route::resource('/entrada', 'EntradaMoradorController')->except('index');