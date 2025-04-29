{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6">
  {{-- Encabezado --}}
  <h1 class="text-2xl font-bold mb-1">Bienvenido(a) {{ auth()->user()->name }}</h1>
  <p
    x-data="{ now: '' }"
    x-init="now = new Date().toLocaleString(); setInterval(() => now = new Date().toLocaleString(), 1000)"
    class="text-sm text-gray-600 mb-6"
  >
    Fecha y hora local: <span x-text="now"></span>
  </p>

  {{-- Estadísticas principales --}}
  <div class="flex justify-center mb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full max-w-4xl">
      @foreach([
        ['color'=>'blue-500','label'=>'Pedidos este mes','value'=>$ordersThisMonth,'icon'=>'fas fa-calendar-alt','route'=>'admin.orders.index'],
        ['color'=>'orange-500','label'=>'Total de pedidos','value'=>$totalOrders,'icon'=>'fas fa-clipboard-list','route'=>'admin.orders.index'],
        ['color'=>'red-500','label'=>'Total gastado','value'=>'COP '.number_format($totalSpent,0,',','.'),'icon'=>'fas fa-dollar-sign','route'=>'admin.orders.index'],
      ] as $stat)
        <div class="relative bg-{{ $stat['color'] }} text-white p-4 rounded-lg shadow-md">
          <p class="text-sm opacity-75">{{ $stat['label'] }}</p>
          <p class="text-2xl font-bold">{{ $stat['value'] }}</p>
          <div class="absolute top-3 right-3 opacity-50 text-3xl">
            <i class="{{ $stat['icon'] }}"></i>
          </div>
          <a href="{{ route($stat['route']) }}" class="mt-3 inline-block text-white hover:underline text-sm">
            Más info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Pedidos: gráfico últimos 7 días y tabla de recientes --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
{{-- Chart de Pedidos últimas 7 días --}}
<div class="bg-white rounded-lg shadow p-4 h-80 overflow-hidden flex flex-col">
  <div class="flex items-center mb-2">
    <h2 class="text-lg font-semibold">Pedidos Últimos 7 Días</h2>
  </div>
  <div class="flex-1 flex items-center justify-center">
    <canvas 
      id="ordersChart" 
      class="w-2/3 h-44"   {{-- ajusta aquí el ancho 2/3 y alto 11rem --}}
    ></canvas>
  </div>
</div>

  {{-- Pedidos Recientes --}}
  <div class="bg-green-50 rounded-lg shadow p-4 h-80 flex flex-col">
    <div class="flex items-center mb-2">
      <i class="fas fa-shopping-cart text-green-500 mr-2"></i>
      <h2 class="text-lg font-semibold">Pedidos Recientes</h2>
    </div>
    <div class="overflow-y-auto flex-1 px-4">
      <table class="table-fixed w-full text-sm">
        <colgroup>
          <col class="w-1/12">
          <col class="w-3/12">
          <col class="w-3/12">
          <col class="w-3/12">
        </colgroup>
        <thead class="bg-gray-100">
          <tr>
            <th class="px-8 py-2 text-left">ID</th>
            <th class="px-8 py-2 text-left">Total</th>
            <th class="px-8 py-2 text-left">Estado</th>
            <th class="px-8 py-2 text-left">Fecha</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentOrders as $order)
            <tr class="border-b even:bg-green-100 hover:bg-green-200">
              <td class="px-8 py-2">{{ $order->id }}</td>
              <td class="px-8 py-2">COP {{ number_format($order->total,0,',','.') }}</td>
              <td class="px-8 py-2">
                <span class="px-2 py-1 rounded-full text-xs
                  {{ Str::lower($order->status)=='pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                  {{ $order->status }}
                </span>
              </td>
              <td class="px-8 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

  {{-- Productos y Tickets --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Products rotativos --}}
    <div x-data="{ showModal: false, modalImage: '' }" class="bg-white rounded-lg shadow p-4 md:col-span-1">
      <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold"><i class="fas fa-star text-yellow-500 mr-2"></i>Productos Destacados</h2>
        <button class="p-2 hover:bg-gray-100 rounded"><i class="fas fa-sync-alt"></i></button>
      </div>
      <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-gray-100 text-left text-sm">
            <th class="px-4 py-2">Producto</th>
            <th class="px-4 py-2">Precio</th>
            <th class="px-4 py-2">Código</th>
          </tr>
        </thead>
        <tbody>
  @foreach($rotatingProducts as $product)
    <tr class="border-b even:bg-gray-50 hover:bg-gray-100">
      {{-- Nombre más pequeño --}}
      <td class="px-1 py-2 flex items-center space-x-2">
        <img
          src="{{ $product->image ? asset('storage/'.$product->image) : asset('img/default-product.png') }}"
          alt="{{ $product->name }}"
          class="w-8 h-8 rounded-full object-cover cursor-pointer"
          @click="modalImage = $event.target.src; showModal = true"
        />
        <span class="text-sm font-medium">{{ $product->name }}</span>
      </td>

      {{-- Precio sin decimales y etiqueta COP --}}
      <td class="px-4 py-2 text-sm">
        {{ number_format($product->price, 0, ',', '.') }} COP
      </td>

      {{-- Código --}}
      <td class="px-4 py-2 text-sm">{{ $product->code }}</td>
    </tr>
  @endforeach
</tbody>

      </table>
      {{-- Modal Zoom --}}
      <div
        x-show="showModal"
        x-transition.opacity
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
        style="display: none;"
      >
        <div class="bg-white p-4 rounded shadow-lg max-w-full max-h-full">
          <img :src="modalImage" alt="Zoomed Image" class="max-w-full max-h-screen rounded" />
          <button
            class="mt-2 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
            @click="showModal = false"
          >Cerrar</button>
        </div>
      </div>
    </div>

    {{-- Tickets Recibidos --}}
    <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
      <div class="flex items-center mb-4">
        <i class="fas fa-ticket-alt text-blue-500 mr-2"></i>
        <h2 class="text-lg font-semibold">Tickets Recibidos</h2>
      </div>
      @if($recentTickets->isEmpty())
        <p class="text-gray-600">No hay tickets recientes.</p>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full table-auto">
            <thead>
              <tr class="bg-gray-100 text-left text-sm">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Asunto</th>
                <th class="px-4 py-2">Categoría</th>
                <th class="px-4 py-2">Prioridad</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Fecha</th>
                <th class="px-4 py-2">Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentTickets as $ticket)
                <tr class="border-b even:bg-gray-50 hover:bg-gray-100">
                  <td class="px-4 py-3 text-sm">{{ $ticket->id }}</td>
                  <td class="px-4 py-3 text-sm truncate">{{ \Illuminate\Support\Str::limit($ticket->subject, 30) }}</td>
                  <td class="px-4 py-3 text-sm">{{ $ticket->category->name ?? '—' }}</td>
                  <td class="px-4 py-3">
                    @switch($ticket->priority)
                      @case('low')
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Low</span>
                        @break
                      @case('medium')
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Medium</span>
                        @break
                      @case('high')
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">High</span>
                        @break
                      @default
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($ticket->priority) }}</span>
                    @endswitch
                  </td>
                  <td class="px-4 py-3 text-sm">{{ ucfirst($ticket->status) }}</td>
                  <td class="px-4 py-3 text-sm">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                  <td class="px-4 py-3 text-sm">
                    <a href="{{ route('tickets.show', $ticket) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                      <i class="fas fa-eye mr-1"></i>Ver
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
      type: 'line', // <-- de 'bar' a 'line'
      data: {
        labels: @json($labels),
        datasets: [{
          label: 'Número de Pedidos',
          data: @json($counts),
          backgroundColor: 'rgba(37, 99, 235, 0.3)',
          borderColor: 'rgba(37, 99, 235, 1)',
          fill: true,        // rellena bajo la línea
          tension: 0.3,      // suaviza la curva
          pointBackgroundColor: 'rgba(37, 99, 235, 1)',
          pointRadius: 4,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'top' },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 1 }
          }
        }
      }
    });
  });
</script>
@endpush



