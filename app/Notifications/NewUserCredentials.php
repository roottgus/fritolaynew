<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserCredentials extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param mixed $user
     * @param string $password
     */
    public function __construct($user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Use Markdown template for consistent branding
        $mail = (new MailMessage)
            ->subject('🔑 Tus credenciales de acceso a FritoLay')
            ->markdown('emails.new_user_credentials', [
                'user'     => $this->user,
                'password' => $this->password,
            ]);

        // Attach inline logo
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
     * Get the array representation of the notification for database.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id'  => $this->user->id,
            'message'  => 'Se han generado credenciales de acceso',
        ];
    }
}
