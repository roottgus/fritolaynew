<?php

namespace App\Listeners;

use App\Events\TicketMessageCreated;
use App\Notifications\NewTicketMessageNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketMessageNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Handle the event.
     *
     * @param  TicketMessageCreated  $event
     * @return void
     */
    public function handle(TicketMessageCreated $event)
    {
        // Extraemos el modelo TicketMessage del evento
        $ticketMessage = $event->message;
        $ticket        = $ticketMessage->ticket;

        // Obtenemos al usuario que abrió el ticket
        $user = $ticket->user;

        // Disparamos la notificación de mensaje nuevo
        $user->notify(new NewTicketMessageNotification($ticketMessage));
    }
}
