<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transferencia;


class TransferenciaController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todas las transferencias desde la base de datos
        $transferencias = Transferencia::all();
        // Envio los datos de las transferencias por un json
        return response()->json(
            [
                'transferencias' => $transferencias,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $transferencia = Transferencia::find($id);
        if (!$transferencia) {
            return response()->json(['message' => 'Transferencia no encontrada'], 404);
        }

        return response()->json(['transferencia' => $transferencia], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Transferencia
        try {
            // Validar la solicitud según las reglas definidas en el modelo Transferencia
            $request->validate(Transferencia::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $transferencia = Transferencia::create([
            'descripcion' => $request->input('descripcion'),
            'fecha' => $request->input('fecha'),
            'monto_dinero' => $request->input('monto_dinero'),
            'tipo' => $request->input('tipo'),
            'tipo_moneda' => $request->input('tipo_moneda'),
            'user_id' => $request->input('user_id'),
            'cuenta_id' => $request->input('cuenta_id'),
        ]);

        return response()->json([
            'message' => 'Transferencia creada correctamente', 
            'transferencia' => $transferencia
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra la transferencia por su ID
        $transferencia = Transferencia::find($id);
        // Verifica si la transferencia existe
        if (!$transferencia) {
            return response()->json(['message' => 'Transferencia no encontrada para eliminarla'], 404);
        }
        // Intenta eliminar la transferencia
        try {
            $transferencia->delete();
            return response()->json(['message' => 'Transferencia eliminada correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar la transferencia, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar la Transferencia'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra la transferencia por su ID
        $transferencia = Transferencia::find($id);

        // Verifica si la transferencia existe
        if (!$transferencia) {
            return response()->json(['message' => 'Transferencia no encontrada para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo Transferencia
            $request->validate(Transferencia::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos de la transferencia
        try {
            $transferencia->update([
                'descripcion' => $request->input('descripcion'),
                'fecha' => $request->input('fecha'),
                'monto_dinero' => $request->input('monto_dinero'),
                'tipo' => $request->input('tipo'),
                'tipo_moneda' => $request->input('tipo_moneda'),
                'user_id' => $request->input('user_id'),
                'cuenta_id' => $request->input('cuenta_id'),
            ]);

            return response()->json([
                'message' => 'Transferencia actualizada correctamente',
                'transferencia' => $transferencia,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar la transferencia, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar la Transferencia'], 500);
        }
    }

}