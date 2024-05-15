<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Juego;
use App\Models\Turno;
use App\Models\GanadorTurno;
use App\Models\User;
use Carbon\Carbon;

use App\Models\JuegoUser;

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
        /////////esto para generar los ganadores

        //obtener el listado de todos los juegos iniciados
        $juegos = Juego::where('estado', 'Iniciado')->get();
        //listado de los ultimos turnos de los juegos iniciados
        $ultimosTurnos = collect([]);
        
        //recorrer el listado de todos los juegos iniciados para obtener su ultimo turno
        foreach ($juegos as $juego) {
            
            //obtengo los tiempos limites para ofertar de dicho juego
            $tiempo_para_ofertar = $juego->tiempo_para_ofertar;
            // Separar las partes de la cadena de tiempo (horas, minutos, segundos)
            list($horas, $minutos, $segundos) = explode(':', $tiempo_para_ofertar);
            //obtener listado de turnos que no esten dentro de la tabla de ganador turnos y ordenado por fecha de creacion el primero
            $ultimoTurno = Turno::where('juego_id', $juego->id)
                ->whereNotIn('id', function ($query) {
                    $query->select('turno_id')->from('ganador_turnos');
                })
                ->orderByDesc('created_at')
                ->first();
            
            //en caso de no encontrar turno
            if ($ultimoTurno) {
                //cuando fue iniciado el turno obtenido
                $fecha_de_creacion_del_turno = Carbon::parse($ultimoTurno->fecha_inicio);
                //obtener la sumatoria de fecha de creacion y el tiempo para ofertar
                $fechaSumatoria = $fecha_de_creacion_del_turno->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);
                //ver si ya el tiempo termino
                if ($fechaSumatoria < now()) {
                    //en caso que el turno ya termino su tiempo para ofertar introducirlo
                    $ultimosTurnos->push($ultimoTurno);
                }
            } else {
                echo "No se encontró ningún turno en el juego id={$juego->id}. \n";
            }
        }

        //recorer todos los turnos que necesitan tener ganador
        $ultimosTurnos->map(function ($turno) {
            $turno = $turno;
            //obtener la gente que oferto por el turno el mayor ofertante solo 1
            $ofertaMayor = $turno->ofertas->sortByDesc('monto_dinero')->first();
            //preguntar si esta vacio en las ofertas
            if($turno->ofertas->isEmpty() || !$ofertaMayor){
                //en caso que este vacio buscar el listado de usuarios no ganadores de ese turno y que esten en el juego
                $jugadores_que_aun_no_ganaron = $turno->obtener_jugadores_que_aun_no_ganado();

                //echo "{$jugadores_que_aun_no_ganaron} \n";
                //echo "=========================================== \n";
                //dd($jugadores_que_aun_no_ganaron);
                //obtener de manera aleatoria al ganador
                $usuario_ganador = $jugadores_que_aun_no_ganaron->random();
                //escogerlo como el ganador del turno
                GanadorTurno::create([
                    'fecha'  => now(),
                    'user_id'  => $usuario_ganador->id,
                    'turno_id'  => $turno->id,
                    'estado' => 'No se puede pagar',
                ]);
            }else{
                //escogerlo como el ganador del turno
                GanadorTurno::create([
                    'fecha'  => now(),
                    'user_id'  => $ofertaMayor->user_id,
                    'turno_id'  => $ofertaMayor->turno->id,
                    'estado' => 'No se puede pagar',
                ]);
            }
        });



        /////////esto para generar los turnos no tocar
        $juegos = Juego::where('estado', 'Iniciado')->get();
        foreach ($juegos as $juego) {
            $turnosCount = Turno::where('juego_id', $juego->id)->count();
            $jugadoresCount = JuegoUser::where('juego_id', $juego->id)
                                        ->where('estado', 'Aceptado')
                                        ->count();
            if ($turnosCount <= $jugadoresCount) {
                echo "El juego {$juego->nombre} {$turnosCount} {$jugadoresCount}\n";
                $ultimoTurno = Turno::where('juego_id', $juego->id)
                                    ->orderBy('fecha_inicio', 'desc')
                                    ->first();
                
                if ($ultimoTurno) {
                    $fechaFinalTurno = $ultimoTurno->fecha_final;
                    $fechaActual = now();
                    list($horas, $minutos, $segundos) = explode(':', $juego->tiempo_por_turno);
                    $fechaFinalNueva = $fechaActual->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);
                    
                    if($fechaActual > $fechaFinalTurno){
                        if ($turnosCount == $jugadoresCount) {
                            $juego->estado = 'Finalizado';
                            $juego->save();
                            echo "El juego {$juego->nombre} se finalizo\n";
                        }else{
                            $turno = Turno::create([
                                'fecha_inicio' => $fechaActual,
                                'fecha_final' => $fechaFinalNueva,
                                'juego_id' => $juego->id,
                            ]);
                            echo "El juego {$juego->nombre} se a creado un nuevo turno\n";
                        }
                    }
                    
                }
            }
        }




    }
}
