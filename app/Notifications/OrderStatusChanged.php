<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $statusLabel = match ($this->order->status) {
            'pending'   => 'Pendiente',
            'completed' => 'Completado',
            'canceled'  => 'Cancelado',
            default     => ucfirst($this->order->status),
        };

        return (new MailMessage)
            ->subject("Pedido #{$this->order->id} – Estado: {$statusLabel}")
            ->markdown('emails.order_status_changed', [
                'order'       => $this->order,
                'statusLabel' => $statusLabel,
                'userName'    => $notifiable->nombre,
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

    public function toArray($notifiable): array
{
    $statusLabel = match ($this->order->status) {
        'pending'   => 'Pendiente',
        'completed' => 'Completado',
        'canceled'  => 'Cancelado',
        default     => ucfirst($this->order->status),
    };

    return [
        'order_id'    => $this->order->id,
        'statusLabel' => $statusLabel,
        'message'     => "Tu pedido ha pasado a estado **{$statusLabel}**.",
    ];
}

    }
