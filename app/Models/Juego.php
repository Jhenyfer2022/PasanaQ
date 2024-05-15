<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_de_inicio',
        'intervalo_tiempo',
        'monto_dinero_individual',
    ];

    public static function rules()
    {
        return [
            'fecha_de_inicio' => 'required|date',
            'intervalo_tiempo' => 'required|integer|min:1',
            'monto_dinero_individual' => 'required|numeric|min:1',
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
