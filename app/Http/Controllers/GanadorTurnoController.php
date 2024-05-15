<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\GanadorTurno;


class GanadorTurnoController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los ganadorturnos desde la base de datos
        $ganadorturnos = GanadorTurno::all();
        // Envio los datos de los ganadorturnos por un json
        return response()->json(
            [
                'ganadorturnos' => $ganadorturnos,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $ganadorturno = GanadorTurno::find($id);
        if (!$ganadorturno) {
            return response()->json(['message' => 'GanadorTurno no encontrado'], 404);
        }

        return response()->json(['ganadorturno' => $ganadorturno], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi GanadorTurno
        try {
            // Validar la solicitud según las reglas definidas en el modelo GanadorTurno
            $request->validate(GanadorTurno::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $ganadorturno = GanadorTurno::create([
            'fecha' => $request->input('fecha'),
            'user_id' => $request->input('user_id'),
            'turno_id' => $request->input('turno_id'),
        ]);

        return response()->json([
            'message' => 'GanadorTurno creado correctamente', 
            'ganadorturno' => $ganadorturno
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el ganadorturno por su ID
        $ganadorturno = GanadorTurno::find($id);
        // Verifica si el ganadorturno existe
        if (!$ganadorturno) {
            return response()->json(['message' => 'GanadorTurno no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el ganadorturno
        try {
            $ganadorturno->delete();
            return response()->json(['message' => 'GanadorTurno eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el ganadorturno, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el GanadorTurno'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el ganadorturno por su ID
        $ganadorturno = GanadorTurno::find($id);

        // Verifica si el ganadorturno existe
        if (!$ganadorturno) {
            return response()->json(['message' => 'GanadorTurno no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo GanadorTurno
            $request->validate(GanadorTurno::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del ganadorturno
        try {
            $ganadorturno->update([
                'fecha' => $request->input('fecha'),
                'user_id' => $request->input('user_id'),
                'turno_id' => $request->input('turno_id'),
            ]);

            return response()->json([
                'message' => 'GanadorTurno actualizado correctamente',
                'ganadorturno' => $ganadorturno,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el ganadorturno, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el GanadorTurno'], 500);
        }
    }
}
