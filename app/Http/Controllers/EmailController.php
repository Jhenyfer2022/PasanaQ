<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Models\Juego;
use App\Models\JuegoUser;

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
        try {
            $juego = Juego::findOrFail( $request->input('juego_id') );
            $email = $request->input('email');
            $subject = 'Te invitamos a participar en el pasanaku: ' . $juego->nombre;
            
            $data = [
                'juego' => $juego,
            ]; // Puedes pasar datos adicionales a la plantilla si es necesario
            DB::beginTransaction();
            JuegoUser::create([
                'identificador_invitacion' => $email,
                'rol_juego' => 'Jugador',
                'juego_id' => $juego->id,
                'user_id' => null,
                'estado' => 'En espera',
            ]);

            Mail::send('mails.invitation', $data, function ($message) use ($email, $subject) {
                $message->to($email)->subject($subject);
            });
            DB::commit();
            return redirect()->back()->with('success', 'El Correo dirigido a: '. $email .' ha sido enviado exitosamente.');
        } catch (\Exception $e) {
            // En caso de excepción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ha ocurrido un error al enviar el correo.');
        }
    }
}

