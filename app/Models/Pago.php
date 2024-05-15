<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'monto_dinero',
        'fecha_limite',
        'tipo',
        'user_id',
        'turno_id',
    ];

    public static function rules()
    {
        return [
            'descripcion' => 'nullable|string',
            'monto_dinero' => 'required|numeric|min:0',
            'fecha_limite' => 'required|date',
            'tipo' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'turno_id' => 'required|exists:turnos,id',
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

    public function transferencias()
    {
        return $this->hasMany(Transferencia::class);
    }
}
