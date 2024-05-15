<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Oferta;


class OfertaController extends Controller
{   //  MOVIL
    public function index_api()
    {
        // Recuperar todas las ofertas desde la base de datos
        $ofertas = Oferta::all();
        // Envio los datos de las ofertas por un json
        return response()->json(
            [
                'ofertas' => $ofertas,
            ], 
            200
        );
    }

    //  MOVIL
    public function show_api($id)
    {
        $oferta = Oferta::find($id);
        if (!$oferta) {
            return response()->json(['message' => 'Oferta no encontrada'], 404);
        }

        return response()->json(['oferta' => $oferta], 200);
    }

    //  MOVIL
    public function store_api(Request $request)
    {
        //validame del modelo las reglas de negocio de mi Oferta
        try {
            // Validar la solicitud según las reglas definidas en el modelo Oferta
            $request->validate(Oferta::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
        $oferta = Oferta::create([
            'monto_dinero' => $request->input('monto_dinero'),
            'fecha' => $request->input('fecha'),
            'user_id' => $request->input('user_id'),
            'turno_id' => $request->input('turno_id'),
        ]);

        return response()->json([
            'message' => 'Oferta creada correctamente', 
            'oferta' => $oferta
        ], 201);
    }
    //  MOVIL
    public function delete_api($id)
    {
        // Encuentra la oferta por su ID
        $oferta = Oferta::find($id);
        // Verifica si la oferta existe
        if (!$oferta) {
            return response()->json(['message' => 'Oferta no encontrada para eliminarla'], 404);
        }
        // Intenta eliminar la oferta
        try {
            $oferta->delete();
            return response()->json(['message' => 'Oferta eliminada correctamente'], 200);
        } catch (\Exception $e) {
            // Si hay algún error al eliminar la oferta, devuelve un mensaje de error
            return response()->json(['message' => 'Error al eliminar la Oferta'], 500);
        }
    }
    //  MOVIL
    public function update_api(Request $request, $id)
    {
        // Encuentra la oferta por su ID
        $oferta = Oferta::find($id);

        // Verifica si la oferta existe
        if (!$oferta) {
            return response()->json(['message' => 'Oferta no encontrada para editar'], 404);
        }

        // Valida los datos de entrada
        try {
            // Validar la solicitud según las reglas definidas en el modelo Oferta
            $request->validate(Oferta::rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación y devuelve una respuesta JSON con los errores
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }

        // Actualiza los datos de la oferta
        try {
            $oferta->update([
                'monto_dinero' => $request->input('monto_dinero'),
                'fecha' => $request->input('fecha'),
                'user_id' => $request->input('user_id'),
                'turno_id' => $request->input('turno_id'),
            ]);

            return response()->json([
                'message' => 'Oferta actualizada correctamente',
                'oferta' => $oferta,
            ], 200);
        } catch (\Exception $e) {
            // Si hay algún error al actualizar la oferta, devuelve un mensaje de error
            return response()->json(['message' => 'Error al actualizar la Oferta'], 500);
        }
    }
}
