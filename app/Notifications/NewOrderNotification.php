<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        // Construimos el MailMessage con tu plantilla Markdown
        $mail = (new MailMessage)
                    ->subject('Nuevo Pedido #' . $this->order->id)
                    ->markdown('emails.admin_new_order', [
                        'order' => $this->order,
                    ]);

        // Ruta al logo en public/img
        $path = public_path('img/dyj.png');

        // Si existe el archivo, lo adjuntamos inline
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
            'order_id'  => $this->order->id,
            'user_name' => $this->order->user->name,
            'total'     => $this->order->total,
            'message'   => 'Nuevo pedido recibido',
        ];
    }
}
