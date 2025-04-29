<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    // Relación con el modelo User para el remitente
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relación con el modelo User para el receptor (opcional si usas receiver_id)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
