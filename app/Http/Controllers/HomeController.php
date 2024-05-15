<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Juego;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener al usuario actualmente autenticado
        $user = Auth::user();
        
        $juegos = $user->juego_users->map(function ($juego_user) {
            return $juego_user->juego;
        });

        return view('home', compact('juegos'));
    }

    public function welcome()
    {
        return view('welcome');
    }
}
