{{-- resources/views/filament/pages/custom-dashboard.blade.php --}}
<x-filament::page>
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
            ['color'=>'blue-500','label'=>'Pedidos este mes','value'=>$ordersThisMonth,'icon'=>'fas fa-calendar-alt','route'=>'filament.admin.resources.orders.index'],
            ['color'=>'orange-500','label'=>'Total de pedidos','value'=>$totalOrders,'icon'=>'fas fa-clipboard-list','route'=>'filament.admin.resources.orders.index'],
            ['color'=>'red-500','label'=>'Total gastado','value'=>'COP '.number_format($totalSpent,0,',','.'),'icon'=>'fas fa-dollar-sign','route'=>'filament.admin.resources.orders.index'],
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
            <canvas id="ordersChart" class="w-2/3 h-44"></canvas>
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
                <col class="w-1/12"><col class="w-3/12"><col class="w-3/12"><col class="w-3/12">
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
                      <span class="px-2 py-1 rounded-full text-xs {{ Str::lower($order->status)=='pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
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

      {{-- Productos Destacados y Tickets Recibidos --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Productos Destacados --}}
        <div x-data="{ showModal: false, modalImage: '' }" class="bg-white rounded-lg shadow p-4 md:col-span-1">
          {{-- … tu tabla de productos … --}}
        </div>
        {{-- Tickets Recibidos --}}
        <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
          {{-- … tu tabla de tickets … --}}
        </div>
      </div>
    </div>

    @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: @json($labels),
            datasets: [{
              label: 'Número de Pedidos',
              data: @json($counts),
              backgroundColor: 'rgba(37, 99, 235, 0.3)',
              borderColor: 'rgba(37, 99, 235, 1)',
              fill: true,
              tension: 0.3,
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
</x-filament::page>
