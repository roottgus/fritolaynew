<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewTicketNotification extends Notification
{
    use Queueable;

    protected Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Usamos plantilla Markdown para nuevo ticket
        $mail = (new MailMessage)
                    ->subject("Nuevo ticket #{$this->ticket->id}")
                    ->markdown('emails.new_ticket', [
                        'ticket'  => $this->ticket,
                        'user'    => $notifiable,
                        'message' => (object)['body' => $this->ticket->message],
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
     * Get the array representation of the notification for storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'subject'   => $this->ticket->subject,
            'message'   => 'Ticket creado',
        ];
    }
}
