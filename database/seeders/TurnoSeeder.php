<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Turno;

class TurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Turno::create([
            'fecha_inicio' => '2024-05-02 17:00:00',
            'fecha_final' => '2024-05-02 17:10:00',
            'juego_id' => 1,
        ]);
        Turno::create([
            'fecha_inicio' => '2024-05-02 17:00:00',
            'fecha_final' => '2024-05-02 17:10:00',
            'juego_id' => 2,
        ]);
    }
}
