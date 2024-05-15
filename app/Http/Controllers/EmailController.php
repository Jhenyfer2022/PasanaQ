<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $email = $request->input('email');
        $data = []; // Puedes pasar datos adicionales a la plantilla si es necesario
        Mail::send('mails.invitation', $data, function ($message) use ($email) {
            $message->to($email)
                    ->subject('Asunto del correo');
        });

        return response()->json(['message' => 'Correo enviado'], 200);
    }

    public function sendEmailWeb(Request $request)
    {
        $email = $request->input('email');
        $data = []; // Puedes pasar datos adicionales a la plantilla si es necesario
        Mail::send('mails.invitation', $data, function ($message) use ($email) {
            $message->to($email)
                    ->subject('Asunto del correo');
        });

        return response()->noContent();
    }
}

