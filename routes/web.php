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

Route::get('/', function () {
    return view('welcome');
});

//Rotas de autenticação de usuário
Auth::routes();
Route::get('/logout', 'Auth\LoginController@userLogout')->name('user.logout');

//Rotas de autenticação de administrador
Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
    Route::get('/', 'AdminController@getIndex')->name('admin.dashboard');
});

Route::get('/home', 'HomeController@index')->name('home');
