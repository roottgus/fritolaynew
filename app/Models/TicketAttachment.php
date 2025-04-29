<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAttachment extends Model
{
    protected $fillable = [
        'message_id',
        'path',
        'filename',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(TicketMessage::class, 'message_id');
    }
}