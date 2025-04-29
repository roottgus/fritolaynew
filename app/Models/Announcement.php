<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    // Permite que estos campos se llenen vía ::create() y ->update()
    protected $fillable = [
        'icon',
        'title',
        'text',
        'active',
    ];

    // Opcional: casteo para trabajar con booleanos directamente
    protected $casts = [
        'active' => 'boolean',
    ];
}
