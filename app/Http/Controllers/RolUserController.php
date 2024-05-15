<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RolUser;


class RolUserController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los rolusers desde la base de datos
        $rolusers = RolUser::all();
        // Envio los datos de los rolusers por un json
        return response()->json(
            [
                'rolusers' => $rolusers,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $roluser = RolUser::find($id);
        if (!$roluser) {
            return response()->json(['message' => 'RolUser no encontrado'], 404);
        }

        return response()->json(['roluser' => $roluser], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi RolUser
        try {
            // Validar la solicitud según las reglas definidas en el modelo RolUser
            $request->validate(RolUser::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $roluser = RolUser::create([
            'rol_id' => $request->input('rol_id'),
            'user_id' => $request->input('user_id'),
        ]);

        return response()->json([
            'message' => 'RolUser creado correctamente', 
            'roluser' => $roluser
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el roluser por su ID
        $roluser = RolUser::find($id);
        // Verifica si el roluser existe
        if (!$roluser) {
            return response()->json(['message' => 'RolUser no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el roluser
        try {
            $roluser->delete();
            return response()->json(['message' => 'RolUser eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el roluser, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el RolUser'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el roluser por su ID
        $roluser = RolUser::find($id);

        // Verifica si el roluser existe
        if (!$roluser) {
            return response()->json(['message' => 'RolUser no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo RolUser
            $request->validate(RolUser::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del roluser
        try {
            $roluser->update([
                'rol_id' => $request->input('rol_id'),
                'user_id' => $request->input('user_id'),
            ]);

            return response()->json([
                'message' => 'RolUser actualizado correctamente',
                'roluser' => $roluser,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el roluser, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el RolUser'], 500);
        }
    }
}
