<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'limite_maximo_de_integrantes',
        'limite_minimo_de_integrantes',
        'fecha_de_inicio',
        'tiempo_por_turno',
        'tiempo_para_ofertar',
        'monto_dinero_individual',
        'estado',
    ];

    public static function rules()
    {
        return [
            'nombre' => 'required|string',
            'limite_maximo_de_integrantes' => 'required|integer|min:1',
            'limite_minimo_de_integrantes' => 'required|integer|min:1',
            'fecha_de_inicio' => 'required|date_format:Y-m-d H:i:s',
            'tiempo_para_ofertar' => 'required|date_format:H:i:s',
            'tiempo_por_turno' => 'required|date_format:H:i:s',
            'monto_dinero_individual' => 'required|numeric|min:1',
            'estado' => 'required|string',
        ];
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    public function juego_users() {
        return $this->hasMany(JuegoUser::class);
    }
}
