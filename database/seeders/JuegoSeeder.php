<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Juego;

class JuegoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Juego::create([
            'nombre' => 'aaa',
            'limite_maximo_de_integrantes' => 3,
            'limite_minimo_de_integrantes' => 2,
            'estado' => 'No Iniciado',
            'fecha_de_inicio' => '2024-05-02 17:00:00',
            'tiempo_por_turno' => '00:2:00',
            'tiempo_para_ofertar' => '00:01:00',
            'monto_dinero_individual' => 5000
        ]);

        Juego::create([
            'nombre' => 'bbb',
            'limite_maximo_de_integrantes' => 4,
            'limite_minimo_de_integrantes' => 3,
            'estado' => 'No Iniciado',
            'fecha_de_inicio' => '2024-05-02 17:00:00',
            'tiempo_por_turno' => '00:2:00',
            'tiempo_para_ofertar' => '00:01:00',
            'monto_dinero_individual' => 5000
        ]);
    }
}
