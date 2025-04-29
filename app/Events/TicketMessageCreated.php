<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\TicketMessage;

class TicketMessageCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public TicketMessage $message;

    public function __construct(TicketMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('ticket.' . $this->message->ticket_id);
    }
}