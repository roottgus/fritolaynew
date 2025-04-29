<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu pedido ha sido recibido',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-received',
        );
    }

    /**
     * Adjunta el logo inline en lugar de usar attachments().
     */
    public function build()
    {
        // adjunta el logo como inline
        return $this
            ->subject('Tu pedido ha sido recibido')
            ->markdown('emails.order-received')
            ->attach(public_path('img/dyj.png'), [
                'as' => 'dyj.png',
                'mime' => 'image/png',
                'disposition' => 'inline',
            ]);
    }
}
