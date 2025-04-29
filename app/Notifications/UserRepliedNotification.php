<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TicketMessage;

class UserRepliedNotification extends Notification
{
    use Queueable;

    /** @var TicketMessage */
    protected TicketMessage $ticketMessage;

    public function __construct(TicketMessage $ticketMessage)
    {
        $this->ticketMessage = $ticketMessage;
    }

    /**
     * Canales: email + base de datos
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Construye el correo para el admin.
     */
    public function toMail($notifiable)
    {
        $ticket = $this->ticketMessage->ticket;

        return (new MailMessage)
            ->subject("El cliente respondió al ticket #{$ticket->id}")
            ->markdown('emails.ticket_updated_user', [
                'ticket'      => $ticket,
                'messageBody' => $this->ticketMessage->body,
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

    /**
     * Datos para la tabla notifications.
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticketMessage->ticket_id,
            'message'   => $this->ticketMessage->body,
        ];
    }
}
