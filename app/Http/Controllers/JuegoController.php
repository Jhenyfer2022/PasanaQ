<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Juego;


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
}