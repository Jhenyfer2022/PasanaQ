<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\Juego;

class WppController extends Controller
{
    public function sendWppWeb(Request $request)
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);
        $tt = $request->input('telephone');
        $telephone = 'whatsapp:'.$tt;
        //$telephone = 'whatsapp:+59177314094';
        $twilioWhatsAppNumber = 'whatsapp:'.env('TWILIO_WHATSHAPP_NUMBER_FROM');
        $juego = Juego::findOrFail( $request->input('juego_id') );
        //dd($juego->nombre);
        $message = "¡Te invitamos a participar en el juego de pasanaku:'.$juego->nombre.'!";

        try {
            $twilio->messages->create(
                $telephone, // to
                array(
                    "from" => $twilioWhatsAppNumber,
                    "body" => $message,
                )
            );
            return redirect()->back()->with('success', 'El WhatsApp dirigido a: '. $tt .' ha sido enviado exitosamente.');
        } catch (\Exception $e) {
            // En caso de excepción
            return redirect()->back()->with('error', 'Ha ocurrido un error al enviar al WhatsApp.');
        }
    }
}
