<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JuegoUser;


class JuegoUserController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los juegousers desde la base de datos
        $juegousers = JuegoUser::all();
        // Envio los datos de los juegousers por un json
        return response()->json(
            [
                'juegousers' => $juegousers,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $juegouser = JuegoUser::find($id);
        if (!$juegouser) {
            return response()->json(['message' => 'JuegoUser no encontrado'], 404);
        }

        return response()->json(['juegouser' => $juegouser], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi JuegoUser
        try {
            // Validar la solicitud según las reglas definidas en el modelo JuegoUser
            $request->validate(JuegoUser::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $juegouser = JuegoUser::create([
            'juego_id' => $request->input('juego_id'),
            'user_id' => $request->input('user_id'),
            'rol_juego' => $request->input('rol_juego'),
        ]);

        return response()->json([
            'message' => 'JuegoUser creado correctamente', 
            'juegouser' => $juegouser
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el juegouser por su ID
        $juegouser = JuegoUser::find($id);
        // Verifica si el juegouser existe
        if (!$juegouser) {
            return response()->json(['message' => 'JuegoUser no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el juegouser
        try {
            $juegouser->delete();
            return response()->json(['message' => 'JuegoUser eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el juegouser, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el JuegoUser'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el juegouser por su ID
        $juegouser = JuegoUser::find($id);

        // Verifica si el juegouser existe
        if (!$juegouser) {
            return response()->json(['message' => 'JuegoUser no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo JuegoUser
            $request->validate(JuegoUser::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del juegouser
        try {
            $juegouser->update([
                'juego_id' => $request->input('juego_id'),
                'user_id' => $request->input('user_id'),
                'rol_juego' => $request->input('rol_juego'),
            ]);

            return response()->json([
                'message' => 'JuegoUser actualizado correctamente',
                'juegouser' => $juegouser,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el juegouser, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el JuegoUser'], 500);
        }
    }
}