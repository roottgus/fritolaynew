{{-- resources/views/emails/order_status_changed.blade.php --}}
<x-mail::message>

<x-slot name="header">
    @include('emails.partials.header')
  </x-slot>


  @php
      switch ($order->status) {
          case 'completed':
              $icon  = '✅';
              $color = '#38c172'; // verde
              break;
          case 'canceled':
              $icon  = '❌';
              $color = '#e3342f'; // rojo
              break;
          default:
              $icon  = '⏳';
              $color = '#3490dc'; // azul/gris
      }
  @endphp

  {{-- Título con color e ícono --}}
  <h1 style="color: {{ $color }}; text-align: center; margin-bottom: 1rem;">
    {!! $icon !!} Pedido #{{ $order->id }} – {{ $statusLabel }}
  </h1>

  {{-- Saludo e información adicional --}}
  Hola {{ $userName }},  
  El estado de tu pedido realizado el **{{ $order->created_at->format('d/m/Y') }}** ha cambiado a **{{ $statusLabel }}**.

  {{-- Detalle de totales --}}
  **Total del pedido:** COP {{ number_format($order->total, 0, ',', '.') }}

  {{-- Botón --}}
  <x-mail::button :url="url('/pedidos')">
    Ver mis pedidos
  </x-mail::button>

  {{-- Despedida --}}
  Gracias por tu preferencia,<br>
  **Equipo {{ config('app.name') }}**

  {{-- Subcopy --}}
  <x-slot name="subcopy">
    Si no solicitaste esta notificación, ignora este correo o contáctanos.
  </x-slot>

</x-mail::message>
