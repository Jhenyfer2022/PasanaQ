<?php

use Illuminate\Http\Request;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/users', 'App\Http\Controllers\UserController@index_api');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@show_api');
Route::post('/users', 'App\Http\Controllers\UserController@store_api');
Route::delete('/users/{id}', 'App\Http\Controllers\UserController@delete_api');
Route::put('/users/{id}', 'App\Http\Controllers\UserController@update_api');

Route::get('/rols', 'App\Http\Controllers\RolController@index_api');
Route::get('/rols/{id}', 'App\Http\Controllers\RolController@show_api');
Route::post('/rols', 'App\Http\Controllers\RolController@store_api');
Route::delete('/rols/{id}', 'App\Http\Controllers\RolController@delete_api');
Route::put('/rols/{id}', 'App\Http\Controllers\RolController@update_api');

Route::get('/cuentas', 'App\Http\Controllers\CuentaController@index_api');
Route::get('/cuentas/{id}', 'App\Http\Controllers\CuentaController@show_api');
Route::post('/cuentas', 'App\Http\Controllers\CuentaController@store_api');




