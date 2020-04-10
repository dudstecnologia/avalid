<?php

// Rotas de Autenticação
Route::namespace('Auth')->group( function () {
    Route::get('login')->uses('LoginController@showLoginForm')->middleware('guest')->name('login');
    Route::post('login')->uses('LoginController@login')->middleware('guest')->name('login.attempt');
    Route::post('logout')->uses('LoginController@logout')->name('logout');
});

Route::middleware('auth')->group( function () {
    Route::get('/', 'DashboardController@index');
    Route::namespace('Admin')->prefix('admin')->name('admin.')->group( function () {
        Route::resource('user', 'UserController');
        Route::get('user-datatable', 'UserController@datatable')->name('user-datatable');
        Route::get('user-alterarstatus/{id}', 'UserController@alterarStatus')->name('user-alterarstatus');
    });
});
