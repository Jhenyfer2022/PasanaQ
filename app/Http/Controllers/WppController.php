<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WppController extends Controller
{
    public function sendWppWeb()
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $telephone = 'whatsapp:'.env('TWILIO_WHATSHAPP_NUMBER');
        //$telephone = 'whatsapp:+59177314094';
        $twilioWhatsAppNumber = 'whatsapp:'.env('TWILIO_WHATSHAPP_NUMBER_FROM');

        $message = "Hello from Porgramaing Experience";

        try {
            $twilio->messages->create(
                $telephone, // to
                array(
                    "from" => $twilioWhatsAppNumber,
                    "body" => $message,
                )
            );
            return response()->json(['message' => 'WhatsApp message sent successfully']);
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()], 500);
        }
    }
}
