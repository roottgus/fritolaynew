<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatusChanged as OrderStatusChangedNotification;

class SendOrderStatusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChanged $event): void
    {
        // Obtiene el pedido y su usuario
        $order = $event->order;
        $user  = $order->user;

        // Envía la notificación al usuario
        Notification::send(
            $user,
            new OrderStatusChangedNotification($order)
        );
    }
}
