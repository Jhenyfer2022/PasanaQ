<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;

use App\Models\Juego;
use App\Models\JuegoUser;

class WppController extends Controller
{
    public function sendWppWeb(Request $request)
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);
        $tt = $request->input('telephone');
        $telephone = 'whatsapp:'.$tt;
        
        $twilioWhatsAppNumber = 'whatsapp:'.env('TWILIO_WHATSHAPP_NUMBER_FROM');
        $juego = Juego::findOrFail( $request->input('juego_id') );
        
        $message = "¡Te invitamos a participar en el juego de pasanaku:'.$juego->nombre.'!";

        try {
            DB::beginTransaction();
            JuegoUser::create([
                'identificador_invitacion' => $telephone,
                'rol_juego' => 'Jugador',
                'juego_id' => $juego->id,
                'user_id' => null,
                'estado' => 'En espera',
            ]);

            $twilio->messages->create(
                $telephone, // to
                array(
                    "from" => $twilioWhatsAppNumber,
                    "body" => $message,
                )
            );
            DB::commit();
            return redirect()->back()->with('success', 'El WhatsApp dirigido a: '. $tt .' ha sido enviado exitosamente.');
        } catch (\Exception $e) {
            // En caso de excepción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ha ocurrido un error al enviar al WhatsApp.');
        }
    }
}
