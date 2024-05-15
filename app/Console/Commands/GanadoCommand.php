<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Juego;
use App\Models\Turno;
use App\Models\GanadorTurno;
use Carbon\Carbon;

class GanadoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ganador:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generamos los ganadores de cada turno de todo los juegos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $juegos = Juego::where('estado', 'Iniciado')->get();
        $ultimosTurnos = collect([]);
        foreach ($juegos as $juego) {
            $tiempo_para_ofertar = $juego->tiempo_para_ofertar;
            // Separar las partes de la cadena de tiempo (horas, minutos, segundos)
            list($horas, $minutos, $segundos) = explode(':', $tiempo_para_ofertar);
            $ultimoTurno = Turno::where('juego_id', $juego->id)
                ->whereNotIn('id', function ($query) {
                    $query->select('turno_id')->from('ganador_turnos');
                })
                ->orderByDesc('created_at')
                ->first();
            $fecha_de_creacion_del_turno = Carbon::parse($ultimoTurno->created_at);
            $fechaSumatoria = $fecha_de_creacion_del_turno->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);

            if ($fechaSumatoria < now()) {
                $ultimosTurnos->push($ultimoTurno);
            }
        }

        $ganadores = $ultimosTurnos->map(function ($turno) {
            $ofertaMayor = $turno->ofertas->sortByDesc('monto_dinero')->first();
            if($turno->ofertas->isEmpty() || !$ofertaMayor){
                //buscar a un usuario del juego de manera random 
            }else{
                //escogerlo como el ganador del turno
                GanadorTurno::create([
                    'fecha'  => now(),
                    'user_id'  => $ofertaMayor->user_id,
                    'turno_id'  => $ofertaMayor->turno->id,
                ]);
            }
        });
        //dd($ultimosTurnos);
    }
}
