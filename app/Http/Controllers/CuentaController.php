<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Models\User;

class CuentaController extends Controller
{
    public function index_api()
    {
        // Recuperar todos las cuentas desde la base de datos
        $cuentas = Cuenta::all();
        // Envio los datos de los rol por un json
        return response()->json(
            [
                'cuentas' => $cuentas,
            ], 
            200
        );
    }
     //  MOVIL
    public function show_api($id)
    {
        $cuenta = Cuenta::find($id);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta no encontrada'], 404);
        }
 
        return response()->json(['cuenta' => $cuenta], 200);
    }
    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Cuenta
        try {
            // Validar la solicitud según las reglas definidas en el modelo Cuenta
            $request->validate(Cuenta::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        $user = User::find($request->input('user_id'));
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado por lo que no se puede registrar la cuenta'], 404);
        }

        $cuenta = Cuenta::create([
            'nombre_banco' => $request->input('nombre_banco'),
            'nro_cuenta' => $request->input('nro_cuenta'),
            'mm' => $request->input('mm'),
            'aa' => $request->input('aa'),
            'cvc' => $request->input('cvc'),
            'ciudad' => $request->input('ciudad'),
            'user_id' => $request->input('user_id'),
        ]);

        return response()->json([
            'message' => 'Cuenta creada correctamente', 
            'cuenta' => $cuenta
        ], 201);
    }
}
