<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

class TicketClosedNotification extends Notification
{
    use Queueable;

    protected Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $ticket = $this->ticket;

        return (new MailMessage)
            ->subject("Tu ticket #{$ticket->id} ha sido cerrado")
            ->markdown('emails.ticket_closed', [
                'ticket' => $ticket,
                'user'   => $notifiable,
            ]);

            // Adjuntamos el logo inline si existe
            $path = public_path('img/dyj.png');
            if (file_exists($path)) {
                $mail->attachData(
                    file_get_contents($path),
                    'dyj.png',
                    [
                        'mime'        => 'image/png',
                        'disposition' => 'inline',
                    ]
                );
            }
    
            return $mail;
        }

    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'message'   => 'Tu ticket ha sido cerrado por el equipo de soporte.',
        ];
    }
}
