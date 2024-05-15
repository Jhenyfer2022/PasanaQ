<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'fecha',
        'monto_dinero',
        'tipo',
        'tipo_moneda',
        'user_id',
        'cuenta_id',
    ];
    
    public static function rules()
    {
        return [
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'monto_dinero' => 'required|numeric|min:0',
            'tipo' => 'required|string',
            'tipo_moneda' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'cuenta_id' => 'required|exists:cuentas,id',
        ];
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
