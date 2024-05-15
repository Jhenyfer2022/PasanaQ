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
        'intervalo_tiempo',
        'monto_dinero_individual',
        'estado',
    ];

    public static function rules()
    {
        return [
            'nombre' => 'required|string',
            'limite_maximo_de_integrantes' => 'required|integer|min:1',
            'limite_minimo_de_integrantes' => 'required|integer|min:1',
            'fecha_de_inicio' => 'required|date',
            'intervalo_tiempo' => 'required|integer|min:1',
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
