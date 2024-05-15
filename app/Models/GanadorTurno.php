<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GanadorTurno extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'user_id',
        'turno_id',
        'qr_gandor_deposito',
        'estado' // no pagar, pagar
    ];

    public static function rules()
    {
        return [
            'fecha' => 'required|date_format:Y-m-d H:i:s',
            'user_id' => 'required|exists:users,id',
            'turno_id' => 'required|exists:turnos,id',
            'qr_gandor_deposito' => 'nullable', // No es requerido
            'estado' => 'required|string', // Se puede pagar, no se puede pagar
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    /*protected static function boot()
    {
        parent::boot();

        static::saved(function ($ganadorTurno) {
            // Obtener el juego del GanadorTurno
            $juego = $ganadorTurno->turno->juego;
            // Obtener los usuarios con estado aceptado de este juego y que no sea el que gano
            $usuarios_a_cobrar = $juego->juego_users()
                ->where('estado', 'Aceptado')
                ->whereNotIn('user_id', [$ganadorTurno->user_id])
                ->get();
            try {
                DB::beginTransaction();
                // Crear una orden de pago para cada usuario aceptado
                foreach ($usuarios_a_cobrar as $usuario) {
                    $pago = Pago::create([
                        "descripcion" => "test",
                        "monto_dinero" => "100",
                        "fecha_limite" => now(),
                        "tipo" => "pago",
                        "user_id" => $usuario->id,
                        "turno_id" => $ganadorTurno->turno_id
                    ]);
                }
                // Commit de la transacción si todo se hizo correctamente
                DB::commit();
            } catch (\Exception $e) {
                // Rollback de la transacción en caso de error
                DB::rollBack();
                throw $e;
            }
        });
    }*/
}
