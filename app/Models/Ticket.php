<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ticket extends Model
{
    protected $fillable = [
       'user_id',
        'subject',
        'message', 
        'status',
        'priority',
        'category_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function messages()
{
    return $this->hasMany(\App\Models\TicketMessage::class)
                ->orderBy('created_at');
}


    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function attachments(): HasManyThrough
    {
        return $this->hasManyThrough(
            TicketAttachment::class,
            TicketMessage::class,
            'ticket_id',   // Foreign key on TicketMessage table
            'message_id',  // Foreign key on TicketAttachment table
            'id',          // Local key on Ticket table
            'id'           // Local key on TicketMessage table
        );
    }
}