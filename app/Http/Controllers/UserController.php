<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//llamada a los modelos
use App\Models\User;

class UserController extends Controller
{
    //movil
    public function index_api()
    {
        // Recuperar todos los usuarios desde la base de datos
        $users = User::all();
        // Envio los datos de los usuarios por un json
        return response()->json(
            [
                'users' => $users,
            ], 
            200
        );
    }
    //movil
    public function show_api($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['user' => $user], 200);
    }
    //movil
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi User
        try {
            // Validar la solicitud según las reglas definidas en el modelo User
            $request->validate(User::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $user = User::create([
            'nombre' => $request->input('nombre'),
            'fecha_de_nacimiento' => $request->input('fecha_de_nacimiento'),
            'telefono' => $request->input('telefono'),
            'ci' => $request->input('ci'),
            'email' => $request->input('email'),
            'direccion' => $request->input('direccion'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente', 
            'user' => $user
        ], 201);
    }
    //movil
    public function delete_api($id)
    {
        // Encuentra al usuario por su ID
        $user = User::find($id);
        // Verifica si el usuario existe
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar al usuario
        try {
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el usuario, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el usuario'], 500);
        }
    }
    //movil
    public function update_api(Request $request, $id)
    {
        // Encuentra al usuario por su ID
        $user = User::find($id);

        // Verifica si el usuario existe
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo User
            $request->validate(User::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del usuario
        try {
            $user->update([
                'nombre' => $request->input('nombre'),
                'fecha_de_nacimiento' => $request->input('fecha_de_nacimiento'),
                'telefono' => $request->input('telefono'),
                'ci' => $request->input('ci'),
                'email' => $request->input('email'),
                'direccion' => $request->input('direccion'),
                'password' => bcrypt($request->input('password')),
            ]);

            return response()->json([
                'message' => 'Usuario actualizado correctamente',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el usuario, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }
    }





    //web
    /*public function index()
    {
        // Recuperar todos los usuarios desde la base de datos
        $users = User::all();
        // Pasar los datos de los usuarios a la vista y renderizarla
        return view('users.index', ['users' => $users]);
    }*/
}
