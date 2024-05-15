<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Juego;
use App\Models\JuegoUser;

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
            'fecha_de_inicio' => $request->input('fecha_de_inicio'),
            'intervalo_tiempo' => $request->input('intervalo_tiempo'),
            'monto_dinero_individual' => $request->input('monto_dinero_individual'),
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
                'fecha_de_inicio' => $request->input('fecha_de_inicio'),
                'intervalo_tiempo' => $request->input('intervalo_tiempo'),
                'monto_dinero_individual' => $request->input('monto_dinero_individual'),
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
            $juego_creado = Juego::create($request->all());
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
}