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
            'fecha_inicio' => 'required|date_format:Y-m-d H:i:s',
            'fecha_final' => 'required|date_format:Y-m-d H:i:s',
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

    public function obtener_jugadores_que_aun_no_ganado()
    {
        $usuarios = $this->juego->juego_users()
            ->whereNotIn('estado', ['En espera'])
            ->whereNotIn('user_id', function ($query) {
                $query->select('user_id')
                    ->from('ganador_turnos')
                    ->join('turnos', 'ganador_turnos.turno_id', '=', 'turnos.id')
                    ->where('turnos.juego_id', $this->juego_id);
            })
            ->get()
            ->map(function ($juegoUser) {
                if($juegoUser->estado == "Retirado"){
                    return $juegoUser->where('rol_juego', 'Lider')->first()->user; 
                }else{
                    return $juegoUser->user;
                }
            });
        
        return $usuarios;
    }

    public function ganador(){
        return $this->ganador_turnos->first();
    }
}
