<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('support-' . $this->message->sender_id),
            new PrivateChannel('support-' . $this->message->receiver_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id'         => $this->message->id,
                'sender_id'  => $this->message->sender_id,
                'message'    => $this->message->message,
                'created_at' => $this->message->created_at->format('H:i'),
            ],
        ];
    }

    // ← Este es el añadido
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}
