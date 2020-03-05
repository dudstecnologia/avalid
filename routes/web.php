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


// Rotas de Autenticação
Route::namespace('Auth')->group( function () {
    Route::get('login')->uses('LoginController@showLoginForm')->middleware('guest')->name('login');
    Route::post('login')->uses('LoginController@login')->middleware('guest')->name('login.attempt');
    Route::post('logout')->uses('LoginController@logout')->name('logout');
});

Route::middleware('auth')->group( function () {
    Route::get('/', function () {
        return 'Está logado';
    });
});
