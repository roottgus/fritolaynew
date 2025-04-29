<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\OrderPlaced;
use App\Listeners\SendOrderConfirmation;
use App\Listeners\SendOrderNotification;

use App\Events\OrderStatusChanged;
use App\Listeners\SendOrderStatusNotification;

use App\Events\TicketMessageCreated;
use App\Listeners\SendTicketMessageNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Evento al crear un pedido
        OrderPlaced::class => [
            SendOrderConfirmation::class,   // Envía email al cliente
            SendOrderNotification::class,   // Notifica al/los admin(es)
        ],

        // Evento al cambiar el estado de un pedido
        OrderStatusChanged::class => [
            SendOrderStatusNotification::class, // Envía email al cliente sobre el estado
        ],

        // Evento al crear un mensaje en un ticket de soporte
        TicketMessageCreated::class => [
            SendTicketMessageNotification::class, // Envía notificación de nuevo mensaje al usuario
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
