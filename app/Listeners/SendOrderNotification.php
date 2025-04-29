<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;
use App\Models\User;

class SendOrderNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event: notifica por mail y BD a los administradores.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        // Notificar a todos los administradores registrados
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewOrderNotification($order));
    }
}