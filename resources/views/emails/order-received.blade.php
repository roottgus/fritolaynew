<x-mail::message>

<x-slot name="header">
    @include('emails.partials.header')
  </x-slot>


# ¡Gracias por tu pedido, {{ $order->user->name }}!

Hemos recibido tu pedido con **ID #{{ $order->id }}** realizado el **{{ $order->created_at->format('d/m/Y') }}**.  
A continuación encontrarás el detalle de los productos solicitados:

<x-mail::table>
| Producto           | Cantidad | Precio unitario  | Subtotal         |
| ------------------ |:--------:| ----------------:| ----------------:|
@foreach($order->items as $item)
| {{ $item['name'] }} | {{ $item['quantity'] }} | COP {{ number_format($item['unit_price'], 0, ',', '.') }} | COP {{ number_format($item['subtotal'], 0, ',', '.') }} |
@endforeach
</x-mail::table>

**Total del pedido:** COP {{ number_format($order->total, 0, ',', '.') }}

<x-mail::button :url="route('mi-cuenta')">
Ver mi historial de pedidos
</x-mail::button>

Gracias por tu preferencia,<br>
**Equipo {{ config('app.name') }}**

</x-mail::message>
