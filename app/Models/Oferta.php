<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto_dinero',
        'fecha',
        'user_id',
        'turno_id',
    ];

    public static function rules()
    {
        return [
            'monto_dinero' => 'required|numeric|min:0',
            'fecha' => 'required|date',
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
}
