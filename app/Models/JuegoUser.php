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
    ];

    public static function rules()
    {
        return [
            'juego_id' => 'required|exists:juegos,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
