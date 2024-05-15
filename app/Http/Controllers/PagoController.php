<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pago;


class PagoController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todos los pagos desde la base de datos
        $pagos = Pago::all();
        // Envio los datos de los pagos por un json
        return response()->json(
            [
                'pagos' => $pagos,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $pago = Pago::find($id);
        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        return response()->json(['pago' => $pago], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Pago
        try {
            // Validar la solicitud según las reglas definidas en el modelo Pago
            $request->validate(Pago::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $pago = Pago::create([
            'descripcion' => $request->input('descripcion'),
            'monto_dinero' => $request->input('monto_dinero'),
            'fecha_limite' => $request->input('fecha_limite'),
            'tipo' => $request->input('tipo'),
            'user_id' => $request->input('user_id'),
            'turno_id' => $request->input('turno_id'),
        ]);

        return response()->json([
            'message' => 'Pago creado correctamente', 
            'pago' => $pago
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra el pago por su ID
        $pago = Pago::find($id);
        // Verifica si el pago existe
        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado para eliminarlo'], 404);
        }
        // Intenta eliminar el pago
        try {
            $pago->delete();
            return response()->json(['message' => 'Pago eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar el pago, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar el Pago'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra el pago por su ID
        $pago = Pago::find($id);

        // Verifica si el pago existe
        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo Pago
            $request->validate(Pago::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos del pago
        try {
            $pago->update([
                'descripcion' => $request->input('descripcion'),
                'monto_dinero' => $request->input('monto_dinero'),
                'fecha_limite' => $request->input('fecha_limite'),
                'tipo' => $request->input('tipo'),
                'user_id' => $request->input('user_id'),
                'turno_id' => $request->input('turno_id'),
            ]);

            return response()->json([
                'message' => 'Pago actualizado correctamente',
                'pago' => $pago,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar el pago, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar el Pago'], 500);
        }
    }

}