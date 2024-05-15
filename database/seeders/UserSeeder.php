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
        $user->telefono = '12345678';
        $user->ci = '1234567';
        $user->email = '1@gmail.com';
        $user->direccion = 'Dirección del usuario';
        $user->password = Hash::make('123123');
        $user->rol_app = 'rol_usuario';
        $user->save();

        $user = new User();
        $user->nombre = 'usuario2';
        $user->fecha_de_nacimiento = '1990-01-01';
        $user->telefono = '22345678';
        $user->ci = '123123123';
        $user->email = '2@gmail.com';
        $user->direccion = 'Dirección del usuario';
        $user->password = Hash::make('123123');
        $user->rol_app = 'rol_usuario';
        $user->save();

        $user = new User();
        $user->nombre = 'NombreUsuario';
        $user->fecha_de_nacimiento = '1990-01-01';
        $user->telefono = '32345678';
        $user->ci = '1234567';
        $user->email = '3@gmail.com';
        $user->direccion = 'Dirección del usuario';
        $user->password = Hash::make('123123');
        $user->rol_app = 'rol_usuario';
        $user->save();
    }
}
