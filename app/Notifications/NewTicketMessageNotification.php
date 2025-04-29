<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TicketMessage;

class NewTicketMessageNotification extends Notification
{
    use Queueable;

    /** @var TicketMessage */
    protected TicketMessage $ticketMessage;

    public function __construct(TicketMessage $ticketMessage)
    {
        $this->ticketMessage = $ticketMessage;
    }

    /**
     * Channels to send the notification.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $ticket = $this->ticketMessage->ticket;

        return (new MailMessage)
                    ->subject("Respuesta a tu ticket #{$ticket->id}: {$ticket->subject}")
                    ->markdown('emails.ticket_updated', [
                        'ticket'        => $ticket,
                        'user'          => $notifiable,
                        'messageBody'   => $this->ticketMessage->body,
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
     * Get the array representation for database storage.
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id'    => $this->ticketMessage->ticket_id,
            'message'      => $this->ticketMessage->body,
        ];
    }
}
