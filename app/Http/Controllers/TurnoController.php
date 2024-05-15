<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Turno;


class TurnoController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los turnos desde la base de datos
        $turnos = Turno::all();
        // Envio los datos de los turnos por un json
        return response()->json(
            [
                'turnos' => $turnos,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $turno = Turno::find($id);
        if (!$turno) {
            return response()->json(['message' => 'Turno no encontrado'], 404);
        }

        return response()->json(['turno' => $turno], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Turno
        try {
            // Validar la solicitud según las reglas definidas en el modelo Turno
            $request->validate(Turno::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $turno = Turno::create([
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_final' => $request->input('fecha_final'),
            'juego_id' => $request->input('juego_id'),
        ]);

        return response()->json([
            'message' => 'Turno creado correctamente', 
            'turno' => $turno
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el turno por su ID
        $turno = Turno::find($id);
        // Verifica si el turno existe
        if (!$turno) {
            return response()->json(['message' => 'Turno no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el turno
        try {
            $turno->delete();
            return response()->json(['message' => 'Turno eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el turno, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el turno'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el turno por su ID
        $turno = Turno::find($id);

        // Verifica si el turno existe
        if (!$turno) {
            return response()->json(['message' => 'Turno no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo Turno
            $request->validate(Turno::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del turno
        try {
            $turno->update([
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_final' => $request->input('fecha_final'),
                'juego_id' => $request->input('juego_id'),
            ]);

            return response()->json([
                'message' => 'Turno actualizado correctamente',
                'turno' => $turno,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el turno, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el turno'], 500);
        }
    }
}
