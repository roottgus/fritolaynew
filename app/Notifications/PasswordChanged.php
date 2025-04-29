<?php
// app/Notifications/PasswordChanged.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordChanged extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
                    ->subject('Tu contraseña ha sido cambiada')
                    ->markdown('emails.password_changed', [
                        'user' => $notifiable,
                    ]);

        $path = public_path('img/dyj.png');
        if (file_exists($path)) {
            $mail->attachData(
                file_get_contents($path),
                'dyj.png',
                ['mime'=>'image/png','disposition'=>'inline']
            );
        }

        return $mail;
    }
}
