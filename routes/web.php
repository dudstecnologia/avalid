<?php

// Rotas de Autenticação
Route::namespace('Auth')->group( function () {
    Route::get('login')->uses('LoginController@showLoginForm')->middleware('guest')->name('login');
    Route::post('login')->uses('LoginController@login')->middleware('guest')->name('login.attempt');
    Route::post('logout')->uses('LoginController@logout')->name('logout');
});

Route::middleware('auth')->group( function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::middleware('admin')->namespace('Admin')->prefix('admin')->name('admin.')->group( function () {
        Route::resource('user', 'UserController');
        Route::get('user-datatable', 'UserController@datatable')->name('user-datatable');
        Route::get('user-alterarstatus/{id}', 'UserController@alterarStatus')->name('user-alterarstatus');

        Route::resource('avaliacao', 'AvaliacaoController');
        Route::get('avaliacao-datatable', 'AvaliacaoController@datatable')->name('avaliacao-datatable');
        
        Route::get('avaliacao-liberar/{id}', 'AvaliacaoController@liberarAvaliacao')->name('avaliacao-liberar');

        Route::get('avaliacao-funcionario-listar', 'AvaliacaoFuncionarioController@listarAvaliacoes')->name('avaliacao-funcionario-listar');
    });

    Route::middleware('funcionario')->namespace('Funcionario')->prefix('funcionario')->name('funcionario.')->group( function () {
        Route::get('verifica-avaliacao', 'AvaliacaoFuncionarioController@verificaAvaliacao')->name('verifica-avaliacao');
        Route::get('lista-avaliados/{avaliacao_funcionario}', 'AvaliacaoFuncionarioController@listaAvaliados')->name('lista-avaliados');
        Route::post('avaliacao', 'AvaliacaoFuncionarioController@store')->name('avaliacao-store');
        Route::resource('user', 'UserController');
    });
});
