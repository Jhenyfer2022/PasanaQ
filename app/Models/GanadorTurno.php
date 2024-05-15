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
}
