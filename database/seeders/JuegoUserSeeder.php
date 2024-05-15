<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\JuegoUser;

class JuegoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //===========================================JUEGO 1
        JuegoUser::create([
            'user_id' => 1,
            'juego_id' => 1,
            'rol_juego' => "Lider",
            'identificador_invitacion' => '1@gmail.com',
            'estado' => "Aceptado"
        ]);
        JuegoUser::create([
            'user_id' => 2,
            'juego_id' => 1,
            'rol_juego' => "Jugador",
            'identificador_invitacion' => '2@gmail.com',
            'estado' => "Aceptado"
        ]);
        JuegoUser::create([
            'user_id' => 3,
            'juego_id' => 1,
            'rol_juego' => "Jugador",
            'identificador_invitacion' => '3@gmail.com',
            'estado' => "Aceptado"
        ]);
        //===========================================JUEGO 2
        JuegoUser::create([
            'user_id' => 1,
            'juego_id' => 2,
            'rol_juego' => "Lider",
            'identificador_invitacion' => '1@gmail.com',
            'estado' => "Aceptado"
        ]);
        JuegoUser::create([
            'user_id' => 2,
            'juego_id' => 2,
            'rol_juego' => "Jugador",
            'identificador_invitacion' => '2@gmail.com',
            'estado' => "Aceptado"
        ]);
        JuegoUser::create([
            'user_id' => 3,
            'juego_id' => 2,
            'rol_juego' => "Jugador",
            'identificador_invitacion' => '3@gmail.com',
            'estado' => "Aceptado"
        ]);
    }
}
