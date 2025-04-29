<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderPlaced
{
    use Dispatchable, SerializesModels;

    /** 
     * La orden recién creada 
     * 
     * @var \App\Models\Order
     */
    public Order $order;

    /**
     * Crea una nueva instancia del evento.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
