<x-mail::message>

<x-slot name="header">
@include('emails.partials.header')
</x-slot>

# Nuevo Pedido #{{ $order->id }}

Se ha recibido un nuevo pedido realizado por **{{ $order->user->name }}** el **{{ $order->created_at->format('d/m/Y') }}**.  

<x-mail::table>
| Producto                  | Cantidad | Subtotal         |
| ------------------------- |:--------:| ----------------:|
@foreach($order->items as $item)
| {{ $item['name'] }}       |    {{ $item['quantity'] }}    | COP {{ number_format($item['subtotal'],0,',','.') }} |
@endforeach
</x-mail::table>

**Total del pedido:** COP {{ number_format($order->total,0,',','.') }}

<x-mail::button :url="url('/admin/pedidos/'.$order->id)">
Ver en panel de administración
</x-mail::button>

Saludos,<br>
**Equipo {{ config('app.name') }}**

</x-mail::message>
