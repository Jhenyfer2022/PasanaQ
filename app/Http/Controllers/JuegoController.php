<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Juego;
use App\Models\JuegoUser;
use App\Models\Turno;
use DateTime;

class JuegoController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los juegos desde la base de datos
        $juegos = Juego::all();
        // Envio los datos de los juegos por un json
        return response()->json(
            [
                'juegos' => $juegos,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $juego = Juego::find($id);
        if (!$juego) {
            return response()->json(['message' => 'Juego no encontrado'], 404);
        }

        return response()->json(['juego' => $juego], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Juego
        try {
            // Validar la solicitud según las reglas definidas en el modelo Juego
            $request->validate(Juego::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $juego = Juego::create([
            'nombre' => $request->input('nombre'),
            'limite_maximo_de_integrantes' => $request->input('limite_maximo_de_integrantes'),
            'limite_minimo_de_integrantes' => $request->input('limite_minimo_de_integrantes'),
            'estado' => $request->input('estado'),
            'fecha_de_inicio' => $request->input('fecha_de_inicio'),
            'tiempo_para_ofertar' => $request->input('tiempo_para_ofertar'),
            'tiempo_por_turno' => $request->input('tiempo_por_turno'),
            'monto_dinero_individual' => $request->input('monto_dinero_individual'),
            'monto_minimo_para_ofertar' => $request->input('monto_minimo_para_ofertar'),
        ]);

        return response()->json([
            'message' => 'Juego creado correctamente', 
            'juego' => $juego
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el juego por su ID
        $juego = Juego::find($id);
        // Verifica si el juego existe
        if (!$juego) {
            return response()->json(['message' => 'Juego no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el juego
        try {
            $juego->delete();
            return response()->json(['message' => 'Juego eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el juego, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el juego'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el juego por su ID
        $juego = Juego::find($id);

        // Verifica si el juego existe
        if (!$juego) {
            return response()->json(['message' => 'Juego no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo Juego
            $request->validate(Juego::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del juego
        try {
            $juego->update([
                'nombre' => $request->input('nombre'),
                'limite_maximo_de_integrantes' => $request->input('limite_maximo_de_integrantes'),
                'limite_minimo_de_integrantes' => $request->input('limite_minimo_de_integrantes'),
                'estado' => $request->input('estado'),
                'fecha_de_inicio' => $request->input('fecha_de_inicio'),
                'tiempo_por_turno' => $request->input('tiempo_por_turno'),
                'monto_dinero_individual' => $request->input('monto_dinero_individual'),
                'tiempo_para_ofertar' => $request->input('tiempo_para_ofertar'),
                'monto_minimo_para_ofertar' => $request->input('monto_minimo_para_ofertar'),
            ]);

            return response()->json([
                'message' => 'Juego actualizado correctamente',
                'juego' => $juego,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el juego, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el juego'], 500);
        }
    }

    public function obtener_listado_de_turnos($id)
    {
        // Encuentra el juego por su ID
        $juego = Juego::find($id);
        if (!$juego) {
            return response()->json(
                [
                    'message' => 'Error al buscar los datos del juego'
                ], 404
            );
        }else{
            $turnos = $juego->turnos()->orderBy('created_at', 'asc')->get();;

            return response()->json(
                [
                    'message' => 'Lista de Turnos', 
                    'turnos' => $turnos
                ], 200
            );
        }
    }















    public function create()
    {
        $juego = null;
        return view('juegos.create', compact('juego'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $juego_creado = Juego::create([
                'nombre' => $request->nombre,
                'limite_maximo_de_integrantes' => $request->limite_maximo_de_integrantes,
                'limite_minimo_de_integrantes' => $request->limite_minimo_de_integrantes,
                'fecha_de_inicio' => $request->fecha_de_inicio,
                'tiempo_para_ofertar' => $request->tiempo_para_ofertar,
                'tiempo_por_turno' => $request->tiempo_por_turno,
                'monto_dinero_individual' => $request->monto_dinero_individual,
                'estado' => "No Iniciado",
            //    $request->all()
            ]);
            $juego_user = JuegoUser::create([
                'identificador_invitacion' => $user->email,
                'rol_juego' => 'Lider',
                'juego_id' => $juego_creado->id,
                'user_id' => $user->id,
                'estado' => 'Aceptado',
            ]);
            DB::commit();
            return redirect('home')->with('success', 'El Juego: '.$juego_creado->nombre.' fue creado exitosamente');
        } catch (\Exception $e) {
            dd($e);
            // En caso de excepción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ha ocurrido un error al crear el juego.');
        }
        
    }

    public function show($id)
    {
        $juego = Juego::findOrFail($id);
        // Obtener los jugadores del juego
        $jugadores = $juego->juego_users;
        return view('juegos.show', compact('juego','jugadores'));
    }

    public function iniciar_juego($id){
        try {
            //Obtener el juego
            $juego = Juego::findOrFail($id);
            //obtener cantidad de jugadores
            $jugadores = $juego->juego_users()->where('estado', 'Aceptado')->get();
            if($jugadores->count() >= $juego->limite_minimo_de_integrantes){
                DB::beginTransaction();
                // Actualizar el campo estado del juego
                $juego->estado = 'Iniciado';
                $juego->save();
                // Crear el primer turno para este juego
                $primer_turno = new Turno();
                $primer_turno->fecha_inicio = now();
                //obtener el tiempo para cada turno
                $tiempo_por_turno = $juego->tiempo_por_turno;
                //obtener la fecha de inicio
                $fecha_inicio = $primer_turno->fecha_inicio;
                // Convertir el tiempo por turno a un formato compatible con DateTime
                $tiempo_array = explode(':', $tiempo_por_turno);
                $horas = $tiempo_array[0];
                $minutos = $tiempo_array[1];
                $segundos = $tiempo_array[2];
                // Sumar el tiempo por turno a la fecha de inicio
                $fecha_final = $fecha_inicio->copy()->addHours($horas)->addMinutes($minutos)->addSeconds($segundos);
                $primer_turno->fecha_final = $fecha_final;
                //indicar de que juego es el turno
                $primer_turno->juego_id = $juego->id; // Asignar el ID del juego al turno
                $primer_turno->save();
                DB::commit();
                return redirect()->back()->with('success', 'El juego ha sido Iniciado correctamente.');
            }else{
                return redirect()->back()->with('error', 'No cumples con el minimo de jugadores para iniciar el juego.');
            }
            
        } catch (\Exception $e) {
            // En caso de excepción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ha ocurrido un error al querer Iniciar el juego.');
        }
    }
}