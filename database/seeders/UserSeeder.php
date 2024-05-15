<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    
    public function run()
    {
        $user = new User();
        $user->nombre = 'NombreUsuario';
        $user->fecha_de_nacimiento = '1990-01-01';
        $user->telefono = '123456789';
        $user->ci = '1234567';
        $user->email = '1@gmail.com';
        $user->direccion = 'Dirección del usuario';
        $user->password = Hash::make('123123');
        $user->rol_app = 'rol_usuario';
        $user->save();
    }
}
