<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'rol_id',
        'user_id',
    ];

    public static function rules()
    {
        return [
            'rol_id' => 'required|exists:rols,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
