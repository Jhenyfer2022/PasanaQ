<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//llamada a los modelos
use App\Models\User;

class UserController extends Controller
{
    //movil listado
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
    //movil ver
    public function show_api($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['user' => $user], 200);
    }
    //movil guardar
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
            'rol_app' => $request->input('rol_app'),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente', 
            'user' => $user
        ], 201);
    }
    //movil eliminar
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
    //movil actualizar
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
                'rol_app' => $request->input('rol_app'),
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
    //movil ver lista de cuentas
    public function index_cuentas_api($id)
    {
        // Encuentra al usuario por su ID
        $user = User::find($id);
        // Verifica si el usuario existe
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado para listar sus cuentas'], 404);
        }
        // Obtén las cuentas del usuario
        //$cuentas = 
        $user->cuentas;
        // Remueve las cuentas del objeto user
        //unset($user->cuentas);
        //obtener respuesta
        return response()->json([
            'message' => 'Usuario obtenido y sus cuentas existentes', 
            'user' => $user,
            //'cuentas' => $cuentas,
        ], 200);
    }
    //credenciales check api
    public function check_user_api(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        // Intenta autenticar al usuario
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json(
                [
                    'user' => $user,
                ], 
                200
            );
        }else{
            // Si hay algún error al actualizar el usuario, devuelve un mensaje de error
            return response()->json(
                [
                    'email' => 'El email puede estar incorrecto. Por favor, inténtelo de nuevo.',
                    'password' => 'La clave puede estar incorrecta. Por favor, inténtelo de nuevo.'
                ], 
                404
            );
        }
    }
    //obtener listado de juegos del usuario
    public function obtener_lista_de_juegos($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'message' => 'Error buscar los datos del usuario'
                ], 404
            );
        }else{
            $juegos = $user->juego_users->map(function ($juego_user) {
                return $juego_user->juego;
            });
            return response()->json(
                [
                    'message' => 'Lista de Juegos', 
                    'juegos' => $juegos
                ], 200
            );
        }
    }

    //web
    public function index()
    {
        // Recuperar todos los usuarios desde la base de datos
        $users = User::all();
        // Pasar los datos de los usuarios a la vista y renderizarla
        return view('users.index', ['users' => $users]);
    }
}
