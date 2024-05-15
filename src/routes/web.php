<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(
    [
        'register' => false, // Deshabilitar el registro de usuarios
        'reset' => false, // Deshabilitar restablecimiento de contraseña
        'verify' => false, // Deshabilitar verificación de correo electrónico
        'confirm' => false, // Deshabilitar confirmación de contraseña
    ]
);

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::middleware(['auth'])->group(function () {
    //Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //todas las rutas de juegos
    Route::resource('juegos', App\Http\Controllers\JuegoController::class);
    //iniciar un juego
    Route::get('/juego/{id}/iniciar_juego', 'App\Http\Controllers\JuegoController@iniciar_juego');
    //Correo ruta para web
    Route::post('/send-email-web', 'App\Http\Controllers\EmailController@sendEmailWeb');
    //WPP ruta para web
    Route::post('/send-wpp-web', 'App\Http\Controllers\WppController@sendWppWeb');
});