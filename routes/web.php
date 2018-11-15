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

Route::get('/', 'HomeController@main')->name('main');

//Rotas de autenticação de usuário
Auth::routes();
Route::get('/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::get('/home', 'HomeController@index')->name('home');

//Rotas de autenticação de administrador
Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    //Rotas para envio de e-mail de resetar a senha de administrador
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    //Rotas para a troca efetiva da senha de administrador
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');

    //Rotas para configuração do sistema
    Route::get('/config', 'ConfigController@index')->name('admin.config');
    Route::post('/config', 'ConfigController@startConfig')->name('admin.config.submit');
    Route::get('/config/ap', 'ConfigController@apIndex')->name('admin.config.ap');
    Route::get('/config/ap/2', 'ConfigController@apDetail')->name('admin.config.ap.detail');
    Route::get('/config/ap/3', 'ConfigController@apDetail2')->name('admin.config.ap.detail2');
    Route::post('/config/ap', 'ConfigController@finishConfig')->name('admin.config.finish');

    //Rotas para cadastro de novos administradores
    Route::prefix('register')->group(function(){
        Route::get('/adm/search', 'AdminController@showSearchForm')->name('adm.search');
        Route::post('/adm/search', 'AdminController@search')->name('adm.search.submit');
        Route::get('/adm/delete/{id}', 'AdminController@delete')->name('admin.delete');
        Route::resource('/adm', 'AdminController');
    });
    
});
