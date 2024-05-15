<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Juego;
use App\Models\Turno;
use App\Models\GanadorTurno;
use App\Models\User;
use App\Models\Pago;
use App\Models\Oferta;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

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
        //obtener el listado de todos los juegos iniciados
        $juegos = Juego::where('estado', 'Iniciado')->get();
        //listado de los ultimos turnos de los juegos iniciados (los que ya pasaro su tiempo para ofertar)
        $ultimosTurnos = $this->obtener_ultimo_turno_de_cada_juego_que_no_tengan_ganadores($juegos);
        //recorer todos los turnos que ya aya pasado su tiempo de ofertar y que necesitan generar ganador
        $this->asignar_un_ganador_para_cada_turno($ultimosTurnos);
        
        //validar si paso el tiempo de los pagos
        $this->generar_Penalizaciones_y_Transferencias_de_los_turnos($juegos);
        //generar los siguientes turnos o finalizar el juego
        $this->generar_siguiente_turno($juegos);
    }

    public function generar_penalizaciones(Turno $turno_objeto, Juego $juego_objeto){
        try {
            DB::beginTransaction();
            //obtener el ganador
            $ganador = $turno_objeto->ganador_turnos()->first();
            // Obtener los usuarios con estado aceptado de este juego y que no sea el que gano
            $usuarios_que_deben_pagar = $juego_objeto->juego_users()
                //->where('estado', 'Aceptado')
                ->whereNotIn('estado', ['En espera'])
                ->whereNotIn('user_id', [$ganador->user_id])
                ->get();
            // recorrer los usuarios 
            foreach ($usuarios_que_deben_pagar as $usuario) {
                //preguntar si el que gano fue un jugador retirado
                if($usuario->estado == "Retirado"){
                    //en caso de que fue un retirado obtener el id del lider del juego
                    $usuario_id = $juego_objeto->obtener_lider_del_juego()->user_id;
                    $contador_deuda_existente = Pago::where('user_id', $usuario_id)
                        ->where('turno_id', $turno_objeto->id)
                        ->where('estado', 'No Pagado')
                        ->where('tipo', 'Cuota')
                        ->count();
                    $contador_penalizaciones_usuario = Pago::where('user_id', $usuario_id)
                        ->where('turno_id', $turno_objeto->id)
                        ->where('tipo', 'Penalizacion')
                        ->count();
                    while ($contador_deuda_existente != $contador_penalizaciones_usuario) {
                        echo "se genero una Penalizacion para el user {$usuario_id}\n";
                        $pago = Pago::create([
                            "descripcion" => "Descripcion de Pago",
                            "monto_dinero" => $juego_objeto->monto_penalizacion,
                            "fecha_limite" => $turno_objeto->fecha_final,
                            "tipo" => "Penalizacion",
                            "user_id" => $usuario_id,
                            "turno_id" => $turno_objeto->id,
                            "estado" => "No Pagado",
                        ]);
                        //incremento el contador de penalizaciones
                        $contador_penalizaciones_usuario = $contador_penalizaciones_usuario + 1;
                    }
                }else{
                    //en caso de que siga en el juego dicho usuario
                    $usuario_id = $usuario->user_id;
                    $deuda_existente = Pago::where('user_id', $usuario_id)
                        ->where('turno_id', $turno_objeto->id)
                        ->where('estado', 'No Pagado')
                        ->where('tipo', 'Cuota')
                        ->first();
                    $contador_deudas_usuario = Pago::where('user_id', $usuario_id)
                        ->where('turno_id', $turno_objeto->id)
                        ->where('tipo', 'Penalizacion')
                        ->count();
                    
                    if($deuda_existente && $contador_deudas_usuario == 0){
                        echo "se genero una Penalizacion para el user {$usuario_id}\n";
                        $pago = Pago::create([
                            "descripcion" => "Descripcion de Pago",
                            "monto_dinero" => $juego_objeto->monto_penalizacion,
                            "fecha_limite" => $turno_objeto->fecha_final,
                            "tipo" => "Penalizacion",
                            "user_id" => $usuario_id,
                            "turno_id" => $turno_objeto->id,
                            "estado" => "No Pagado",
                        ]);
                    }
                    echo "contadordeudas = {$contador_deudas_usuario} ||| {$turno_objeto->fecha_final} \n";
                    if($contador_deudas_usuario != 0 && now() > $turno_objeto->fecha_final){
                        if($usuario->rol_juego != "Lider"){
                            echo "genero la transferencia\n";
                            //transferir pago al lider
                            $pago = Pago::create([
                                "descripcion" => "Transferencia de deuda del jugador identificador: {$usuario->identificador_invitacion}",
                                "monto_dinero" => $turno_objeto->ganador()->qr_monto + $juego_objeto->monto_penalizacion,
                                "fecha_limite" => now(),
                                "tipo" => "Transferencia",
                                "user_id" => $juego_objeto->obtener_lider_del_juego()->user_id,
                                "turno_id" => $turno_objeto->id,
                                "estado" => "No Pagado",
                            ]);
                            //cambiar el estado del jugador
                        
                            $usuario->estado = "Retirado";
                            $usuario->save();
                        }
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            // Rollback de la transacción en caso de error
            DB::rollBack();
            throw $e;
        }
    }

    public function generar_Penalizaciones_y_Transferencias_de_los_turnos($juegos){
        //obtener los ultimos turnos que tienen ya un ganador y finalizo su tiempo de pago
        $ultimosTurnos = collect([]);
        //recorrer el listado de todos los juegos iniciados para obtener su ultimo turno
        foreach ($juegos as $juego) {
            //obtener listado de turnos que no esten dentro de la tabla de ganador turnos y ordenado por fecha de creacion el primero
            $ultimoTurno = Turno::where('juego_id', $juego->id)
                ->whereIn('id', function ($query) {
                    $query->select('turno_id')->from('ganador_turnos');
                })
                ->orderByDesc('created_at')
                ->first();
            if ($ultimoTurno !== null) {
                $ultimosTurnos->push($ultimoTurno);
            }
        }
        //recorer todos los turnos que necesitan tener ganador
        $ultimosTurnos->map(function ($turno) {
            $juego = $turno->juego;
            
            //tiempo limite para pagar

            $tiempo_finaliza_turno = Carbon::createFromFormat('Y-m-d H:i:s', $turno->fecha_final);
            list($horas, $minutos, $segundos) = explode(':', $juego->tiempo_para_pagar_todo);
            $tiempo_finaliza_turno->subHours($horas/2)->subMinutes($minutos/2)->subSeconds($segundos/2);

            echo "$tiempo_finaliza_turno \n";
            if( $tiempo_finaliza_turno->isPast() ){
                echo "entre metodo generar_penalizaciones\n";
                $this->generar_penalizaciones($turno, $turno->juego);
            }
        });
    }

    public function generar_siguiente_turno($juegos){
        foreach ($juegos as $juego) {
            $turnosCount = Turno::where('juego_id', $juego->id)->count();
            $jugadoresCount = JuegoUser::where('juego_id', $juego->id)
                                        //->where('estado', 'Aceptado')
                                        ->whereNotIn('estado', ['En espera'])
                                        ->count();
            if ($turnosCount <= $jugadoresCount) {
                echo "El juego {$juego->nombre} {$turnosCount} {$jugadoresCount}\n";
                $ultimoTurno = Turno::where('juego_id', $juego->id)
                                    ->orderBy('fecha_inicio', 'desc')
                                    ->first();
                
                if ($ultimoTurno) {
                    $fechaFinalTurno = $ultimoTurno->fecha_final;
                    $fechaActual = now();
                    //$juego->tiempo_para_ofertar
                    //$juego->tiempo_para_pagar_todo
                    $tiempo_para_pagar_todo = Carbon::createFromFormat('H:i:s', $juego->tiempo_para_pagar_todo);
                    $tiempo_para_ofertar = Carbon::createFromFormat('H:i:s', $juego->tiempo_para_ofertar);

                    $tiempo_total = $tiempo_para_pagar_todo->addHours($tiempo_para_ofertar->hour)
                                                        ->addMinutes($tiempo_para_ofertar->minute)
                                                        ->addSeconds($tiempo_para_ofertar->second);
                    
                    list($horas, $minutos, $segundos) = explode(':', $tiempo_total);
                    //list($horas, $minutos, $segundos) = explode(':', $juego->tiempo_por_turno);
                    $fechaFinalNueva = $fechaActual->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);
                    
                    if($fechaActual > $fechaFinalTurno){
                        if ($turnosCount == $jugadoresCount) {
                            $juego->estado = 'Finalizado';
                            $juego->save();
                            echo "El juego {$juego->nombre} se finalizo\n";
                        }else{
                            //crear el siguiente turno
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

    public function obtener_ultimo_turno_de_cada_juego_que_no_tengan_ganadores($juegos){
        $ultimosTurnos = collect([]);
        //recorrer el listado de todos los juegos iniciados para obtener su ultimo turno
        foreach ($juegos as $juego) {
            
            //obtener listado de turnos que no esten dentro de la tabla de ganador turnos y ordenado por fecha de creacion el primero
            $ultimoTurno = Turno::where('juego_id', $juego->id)
                ->whereNotIn('id', function ($query) {
                    $query->select('turno_id')->from('ganador_turnos');
                })
                ->orderByDesc('created_at')
                ->first();
            
            //encontre turno que necesita un ganador
            if ($ultimoTurno) {
                //obtengo los tiempos limites para ofertar de dicho juego
                $tiempo_para_ofertar = $juego->tiempo_para_ofertar;
                // Separar las partes de la cadena de tiempo (horas, minutos, segundos)
                list($horas, $minutos, $segundos) = explode(':', $tiempo_para_ofertar);
                //cuando fue iniciado el turno obtenido
                $fecha_de_creacion_del_turno = Carbon::parse($ultimoTurno->fecha_inicio);
                //obtener el tiempo para ofertar
                $tiempo_para_ofertar = $fecha_de_creacion_del_turno->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);
                //ver si ya el tiempo termino para ofertar
                if ($tiempo_para_ofertar < now()) {
                    //en caso que el turno ya termino su tiempo para ofertar introducirlo
                    $ultimosTurnos->push($ultimoTurno);
                }else{
                    echo "El juego id = {$juego->id} tiene tiempo para ofertar. \n";
                }
            } else {
                echo "No se encontró ningún turno en el juego id={$juego->id} que necesite un ganador. \n";
            }
        }
        return $ultimosTurnos;
    }

    public function asignar_un_ganador_para_cada_turno($ultimosTurnos){
        //recorer todos los turnos que necesitan tener ganador
        $ultimosTurnos->map(function ($turno) {
            //obtener la gente que oferto por el turno el mayor ofertante solo 1
            $ofertaMayor = $turno->ofertas->sortByDesc('monto_dinero')->first();
            //preguntar si esta vacio en las ofertas
            if($turno->ofertas->isEmpty() || !$ofertaMayor){
                //en caso que este vacio buscar el listado de usuarios no ganadores de ese turno y que esten en el juego
                $jugadores_que_aun_no_ganaron = $turno->obtener_jugadores_que_aun_no_ganado();

                //echo "{$jugadores_que_aun_no_ganaron} \n";
                //obtener de manera aleatoria al ganador
                $usuario_ganador = $jugadores_que_aun_no_ganaron->random();
                //escogerlo como el ganador del turno
                $this->guardar_ganador_turno($usuario_ganador->id, $turno->id);
            }else{
                //escogerlo como el ganador del turno
                $this->guardar_ganador_turno($ofertaMayor->user_id, $ofertaMayor->turno->id);
            }
        });
    }

    public function guardar_ganador_turno($user_id, $turno_id)
    {
        try {
            DB::beginTransaction();
            $ganadorTurno = new GanadorTurno();
            $ganadorTurno->fecha = now();
            $ganadorTurno->user_id = $user_id;
            $ganadorTurno->turno_id = $turno_id;
            $ganadorTurno->estado = 'No se puede pagar';
            $ganadorTurno->save();

            // Obtener el juego del GanadorTurno
            $juego = $ganadorTurno->turno->juego;
            // Obtener los usuarios con estado aceptado de este juego y que no sea el que gano
            $usuarios_a_cobrar = $juego->juego_users()
                //->where('estado', 'Aceptado')
                ->whereNotIn('estado', ['En espera'])
                ->whereNotIn('user_id', [$ganadorTurno->user_id])
                ->get();
            //obtencion de la oferta que realizo en dicho turnno
            $oferta = Oferta::where('user_id', $user_id)
                ->where('turno_id', $turno_id)
                ->first();
            //resta de montos para monto a pagar nuevo
            $monto_de_dinero = $juego->monto_dinero_individual;
            if($oferta)
            {
                //si hay una oferta realizada por el jugador ganador restar este monto dividido en los jugadores
                $monto_de_dinero = $juego->monto_dinero_individual - ( $oferta->monto_dinero / $usuarios_a_cobrar->count() );
            }
            
            $ganadorTurno->qr_monto = $monto_de_dinero;
            $ganadorTurno->save();

            //tiempo limite para pagar
            $fecha_actual = now();
            list($horas, $minutos, $segundos) = explode(':', $juego->tiempo_para_pagar_todo);
            $fecha_limite = $fecha_actual->addHours($horas/2)
                                                ->addMinutes($minutos/2)
                                                ->addSeconds($segundos/2);
            
            // Crear una orden de pago para cada usuario aceptado
            foreach ($usuarios_a_cobrar as $usuario) {
                $user_id = $usuario->user_id;
                if($usuario->estado == "Retirado")
                {
                    $user_id = $ganadorTurno->turno->juego->obtener_lider_del_juego()->user_id;
                }
                $pago = Pago::create([
                    "descripcion" => "Descripcion de Pago",
                    "monto_dinero" => $monto_de_dinero,
                    "fecha_limite" => $fecha_limite,
                    "tipo" => "Cuota",
                    "user_id" => $user_id,
                    "turno_id" => $ganadorTurno->turno_id,
                    "estado" => "No Pagado",
                ]);
            }
            // Commit de la transacción si todo se hizo correctamente
            DB::commit();
        } catch (\Exception $e) {
            // Rollback de la transacción en caso de error
            DB::rollBack();
            throw $e;
        }
    }

}
