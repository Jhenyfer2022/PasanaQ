<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GanadorTurno extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'user_id',
        'turno_id',
    ];

    public static function rules()
    {
        return [
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
