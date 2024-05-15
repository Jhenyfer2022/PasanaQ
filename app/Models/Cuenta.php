<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre_banco',
        'nro_cuenta',
        'mm',
        'aa',
        'cvc',
        'ciudad',
        'user_id'
        
    ];

    public static function rules()
    {
        return [
            'nombre_banco' => 'required|string',
            'nro_cuenta' => 'required|string',
            'mm' => 'required|integer',
            'aa' => 'required|integer',
            'cvc' => 'required|integer',
            'ciudad' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transferencias()
    {
        return $this->hasMany(Transferencia::class);
    }
}
