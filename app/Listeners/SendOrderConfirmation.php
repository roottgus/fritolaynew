<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceived;

class SendOrderConfirmation implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event: envía un email al usuario que hizo el pedido.
     */
    public function handle(OrderPlaced $event): void
    {
        Mail::to($event->order->user->email)
            ->send(new OrderReceived($event->order));
    }
}
