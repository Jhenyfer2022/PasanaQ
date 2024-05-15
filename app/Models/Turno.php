<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_inicio',
        'fecha_final',
        'juego_id',
    ];

    public static function rules()
    {
        return [
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
            'juego_id' => 'required|exists:juegos,id',
        ];
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }
    
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function ganador_turnos()
    {
        return $this->hasMany(GanadorTurno::class);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }
}
