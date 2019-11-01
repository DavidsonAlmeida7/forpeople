<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'namespace' => 'Api\\'], function() {

    Route::get('/funcionarios/list',      'FuncionarioController@index');
    Route::get('/funcionarios/show/{id}', 'FuncionarioController@show');
    Route::post('/funcionarios/create',   'FuncionarioController@create');
    Route::post('/funcionarios/destroy',  'FuncionarioController@destroy');
    Route::post('/funcionarios/update/{id}',   'FuncionarioController@update');
});