<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'origin',
        'items',
    ];

    // Si prefieres que 'items' se maneje automáticamente como array:
    protected $casts = [
        'items' => 'array',
    ];
    /**
     * Relación: un pedido pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
