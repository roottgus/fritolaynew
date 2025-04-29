<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Ticket;

Broadcast::channel('ticket.{ticketId}', function ($user, $ticketId) {
    return $user->id === Ticket::find($ticketId)->user_id || $user->isAdmin();
});
