<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Rol;


class RolController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los roles desde la base de datos
        $rols = Rol::all();
        // Envio los datos de los rol por un json
        return response()->json(
            [
                'rols' => $rols,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        return response()->json(['rol' => $rol], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Rol
        try {
            // Validar la solicitud según las reglas definidas en el modelo Rol
            $request->validate(Rol::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $rol = Rol::create([
            'nombre' => $request->input('nombre'),
            'detalle' => $request->input('detalle'),
        ]);

        return response()->json([
            'message' => 'Rol creado correctamente', 
            'rol' => $rol
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el rol por su ID
        $rol = Rol::find($id);
        // Verifica si el rol existe
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el rol
        try {
            $rol->delete();
            return response()->json(['message' => 'Rol eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el rol, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el rol'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el rol por su ID
        $rol = Rol::find($id);

        // Verifica si el rol existe
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo Rol
            $request->validate(Rol::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del rol
        try {
            $rol->update([
                'nombre' => $request->input('nombre'),
                'detalle' => $request->input('detalle'),
            ]);

            return response()->json([
                'message' => 'Rol actualizado correctamente',
                'rol' => $rol,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el rol, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el rol'], 500);
        }
    }

    



}
