<?php

use Illuminate\Support\Facades\Route;

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

Route::post('insercao', 'App\Http\Controllers\NomeController@inserir')->name('insercao');
Route::get('lista/{numero}', 'App\Http\Controllers\NomeController@listar')->name('lista');
