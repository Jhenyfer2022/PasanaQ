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
Route::get('/users/{id}/cuentas', 'App\Http\Controllers\UserController@index_cuentas_api');

Route::get('/juegos', 'App\Http\Controllers\JuegoController@index_api');
Route::get('/juegos/{id}', 'App\Http\Controllers\JuegoController@show_api');
Route::post('/juegos', 'App\Http\Controllers\JuegoController@store_api');
Route::delete('/juegos/{id}', 'App\Http\Controllers\JuegoController@delete_api');
Route::put('/juegos/{id}', 'App\Http\Controllers\JuegoController@update_api');

Route::get('/turnos', 'App\Http\Controllers\TurnoController@index_api');
Route::get('/turnos/{id}', 'App\Http\Controllers\TurnoController@show_api');
Route::post('/turnos', 'App\Http\Controllers\TurnoController@store_api');
Route::delete('/turnos/{id}', 'App\Http\Controllers\TurnoController@delete_api');
Route::put('/turnos/{id}', 'App\Http\Controllers\TurnoController@update_api');

Route::get('/juegousers', 'App\Http\Controllers\JuegoUserController@index_api');
Route::get('/juegousers/{id}', 'App\Http\Controllers\JuegoUserController@show_api');
Route::post('/juegousers', 'App\Http\Controllers\JuegoUserController@store_api');
Route::delete('/juegousers/{id}', 'App\Http\Controllers\JuegoUserController@delete_api');
Route::put('/juegousers/{id}', 'App\Http\Controllers\JuegoUserController@update_api');

Route::get('/pagos', 'App\Http\Controllers\PagoController@index_api');
Route::get('/pagos/{id}', 'App\Http\Controllers\PagoController@show_api');
Route::post('/pagos', 'App\Http\Controllers\PagoController@store_api');
Route::delete('/pagos/{id}', 'App\Http\Controllers\PagoController@delete_api');
Route::put('/pagos/{id}', 'App\Http\Controllers\PagoController@update_api');

Route::get('/ganadorturnos', 'App\Http\Controllers\GanadorTurnoController@index_api');
Route::get('/ganadorturnos/{id}', 'App\Http\Controllers\GanadorTurnoController@show_api');
Route::post('/ganadorturnos', 'App\Http\Controllers\GanadorTurnoController@store_api');
Route::delete('/ganadorturnos/{id}', 'App\Http\Controllers\GanadorTurnoController@delete_api');
Route::put('/ganadorturnos/{id}', 'App\Http\Controllers\GanadorTurnoController@update_api');

Route::get('/ofertas', 'App\Http\Controllers\OfertaController@index_api');
Route::get('/ofertas/{id}', 'App\Http\Controllers\OfertaController@show_api');
Route::post('/ofertas', 'App\Http\Controllers\OfertaController@store_api');
Route::delete('/ofertas/{id}', 'App\Http\Controllers\OfertaController@delete_api');
Route::put('/ofertas/{id}', 'App\Http\Controllers\OfertaController@update_api');

Route::get('/cuentas', 'App\Http\Controllers\CuentaController@index_api');
Route::get('/cuentas/{id}', 'App\Http\Controllers\CuentaController@show_api');
Route::post('/cuentas', 'App\Http\Controllers\CuentaController@store_api');
Route::delete('/cuentas/{id}', 'App\Http\Controllers\CuentaController@delete_api');
Route::put('/cuentas/{id}', 'App\Http\Controllers\CuentaController@update_api');

Route::get('/transferencias', 'App\Http\Controllers\TransferenciaController@index_api');
Route::get('/transferencias/{id}', 'App\Http\Controllers\TransferenciaController@show_api');
Route::post('/transferencias', 'App\Http\Controllers\TransferenciaController@store_api');
Route::delete('/transferencias/{id}', 'App\Http\Controllers\TransferenciaController@delete_api');
Route::put('/transferencias/{id}', 'App\Http\Controllers\TransferenciaController@update_api');