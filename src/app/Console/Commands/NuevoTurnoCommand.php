<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Juego;
use App\Models\Turno;
use App\Models\JuegoUser;

class NuevoTurnoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turno:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar nuevo turno al finalizar un turno';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $juegos = Juego::where('estado', 'Iniciado')->get();
        foreach ($juegos as $juego) {
            $turnosCount = Turno::where('juego_id', $juego->id)->count();
            $jugadoresCount = JuegoUser::where('juego_id', $juego->id)
                                        ->where('estado', 'Aceptado')
                                        ->count();
        
            if ($turnosCount < $jugadoresCount) {
                $ultimoTurno = Turno::where('juego_id', $juego->id)
                                    ->orderBy('fecha_inicio', 'desc')
                                    ->first();
                
                if ($ultimoTurno) {
                    $fechaFinalTurno = $ultimoTurno->fecha_final;
                    $fechaActual = now();
                    list($horas, $minutos, $segundos) = explode(':', $juego->tiempo_por_turno);
                    $fechaFinalNueva = $fechaActual->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);
                    if ($fechaActual > $fechaFinalTurno) {
                        $turno = Turno::create([
                            'fecha_inicio' => $fechaActual,
                            'fecha_final' => $fechaFinalNueva,
                            'juego_id' => $juego->id,
                        ]);
                        echo "El juego {$juego->nombre} se a creado un nuevo turno\n";
                    }
                }
                //echo "El juego {$juego->nombre} necesita más turnos\n";
            }
        }
    }
}
