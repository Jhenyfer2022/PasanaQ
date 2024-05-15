<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuegoUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'juego_id',
        'user_id',
        'rol_juego',
        'identificador_invitacion',
        'estado',
    ];

    public static function rules()
    {
        return [
            'identificador_invitacion' => 'required|string',
            'juego_id' => 'required|exists:juegos,id',
            'user_id' => 'nullable|exists:users,id', // Ahora user_id es nullable
            'rol_juego' => 'required|string',
            'estado' => 'required|string',
        ];
    }
    //estado puede ser Aceptado, Rechazado, En espera
    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}