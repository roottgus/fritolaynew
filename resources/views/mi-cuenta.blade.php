{{-- resources/views/mi-cuenta.blade.php --}}
@extends('layouts.app-user')

@section('content')
<div x-data="{ showPasswordModal: false, verPedidoModal: false, pedidoSeleccionado: null }" x-cloak class="p-4">

  <!-- Encabezado y botón de contraseña -->
  <div class="mb-6 flex items-center justify-between flex-wrap gap-2">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Mi Cuenta</h1>
      <p class="text-sm text-gray-500">Resumen de tu perfil y actividad reciente.</p>
    </div>
    <button @click="showPasswordModal = true"
            class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded font-medium text-sm">
      <i class="fas fa-key"></i>
      Cambiar contraseña
    </button>
  </div>

  {{-- Tarjetas superiores --}}
  <div class="max-w-4xl mx-auto mb-8">
    <div class="flex flex-wrap justify-center gap-6">
      <!-- Nombre -->
      <div class="bg-white border-l-4 border-yellow-500 shadow rounded-lg p-3 flex items-center gap-2 max-w-xs hover:bg-yellow-50">
        <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
          <i class="fas fa-user text-lg"></i>
        </div>
        <div>
          <h3 class="text-xs text-gray-500 uppercase">Nombre</h3>
          <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
        </div>
      </div>
      <!-- Negocio -->
      <div class="bg-white border-l-4 border-yellow-500 shadow rounded-lg p-3 flex items-center gap-2 max-w-xs hover:bg-yellow-50">
        <div class="bg-green-100 text-green-600 p-2 rounded-full">
          <i class="fas fa-building text-lg"></i>
        </div>
        <div>
          <h3 class="text-xs text-gray-500 uppercase">Negocio</h3>
          <p class="text-base font-semibold text-gray-800">
            {{ $user->business_name ?? 'No definido' }}
          </p>
        </div>
      </div>
      <!-- Total de pedidos -->
      <div class="bg-white border-l-4 border-yellow-500 shadow rounded-lg p-3 flex items-center gap-2 max-w-xs hover:bg-yellow-50">
        <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full">
          <i class="fas fa-shopping-bag text-lg"></i>
        </div>
        <div>
          <h3 class="text-xs text-gray-500 uppercase">Total de pedidos</h3>
          <p class="text-base font-semibold text-gray-800">{{ $orders->count() }}</p>
        </div>
      </div>
      <!-- Monto total -->
      <div class="bg-white border-l-4 border-yellow-500 shadow rounded-lg p-3 flex items-center gap-2 max-w-xs hover:bg-yellow-50">
        <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
          <i class="fas fa-dollar-sign text-lg"></i>
        </div>
        <div>
          <h3 class="text-xs text-gray-500 uppercase">Monto total de pedidos</h3>
          <p class="text-base font-semibold text-gray-800">
            COP {{ number_format($orders->sum('total'), 2, ',', '.') }}
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Historial de Pedidos con scroll -->
  <div class="bg-white rounded-lg shadow mb-10 border-l-4 border-red-500">
    <div class="px-6 py-4 bg-gray-50 border-b">
      <h2 class="text-lg font-semibold text-gray-700">
        <i class="fas fa-history mr-2"></i>Historial de Pedidos
      </h2>
    </div>
    <div class="overflow-x-auto">
      <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-left text-gray-700">
          <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
              <th class="px-6 py-3">#</th>
              <th class="px-6 py-3">Fecha</th>
              <th class="px-6 py-3">Total</th>
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr class="border-t hover:bg-gray-50 transition">
                <td class="px-6 py-3 font-medium">{{ $order->id }}</td>
                <td class="px-6 py-3">{{ $order->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-3 text-green-600 font-semibold">
                  COP {{ number_format($order->total,0,',','.') }}
                </td>
                <td class="px-6 py-3">
                  <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $order->status == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ $order->status }}
                  </span>
                </td>
                <td class="px-6 py-3">
                  <button
                    class="text-blue-600 hover:underline text-sm font-medium"
                    data-order='@json($order)'
                    @click="
                      pedidoSeleccionado = JSON.parse($event.currentTarget.dataset.order);
                      verPedidoModal = true;
                    "
                  >
                    Ver Pedido
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Anuncios -->
  @include('partials.announcements')

  <!-- Ofertas -->
  @include('partials.offers')

  <!-- Modal Ver Pedido -->
  <template x-if="verPedidoModal && pedidoSeleccionado">
    <div
      x-show="verPedidoModal"
      x-cloak
      x-transition.opacity.duration.200ms
      class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center px-4"
      @click.self="verPedidoModal = false"
    >
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="flex items-center justify-between bg-gradient-to-r from-yellow-400 via-yellow-500 to-red-600 px-6 py-4">
          <div class="flex items-center space-x-3">
            <img src="{{ asset('img/dyj.png') }}"
                 alt="Logo Empresa"
                 class="h-10 w-10 rounded-full bg-white p-1" />
            <div>
              <h3 class="text-xl font-semibold text-white">
                Pedido #<span x-text="pedidoSeleccionado.id"></span>
              </h3>
              <p class="text-sm text-white/80"
                 x-text="'Fecha: ' + pedidoSeleccionado.created_at.split('T')[0]">
              </p>
            </div>
          </div>
          <button @click="verPedidoModal = false"
                  class="text-white text-2xl hover:opacity-80">&times;</button>
        </div>
        <div class="px-6 py-5 space-y-6">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-500">Total</p>
              <p class="text-lg font-bold text-gray-800"
                 x-text="'COP ' + Number(pedidoSeleccionado.total).toLocaleString()">
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Estado</p>
              <span x-text="pedidoSeleccionado.status"
                    class="inline-block px-3 py-1 text-xs font-medium rounded-full"
                    :class="{
                      'bg-green-100 text-green-800': pedidoSeleccionado.status === 'Confirmado',
                      'bg-yellow-100 text-yellow-800': pedidoSeleccionado.status === 'Pendiente',
                      'bg-red-100 text-red-800': pedidoSeleccionado.status === 'Cancelado'
                    }">
              </span>
            </div>
          </div>
          <div class="overflow-auto">
            <table class="w-full table-auto text-left">
              <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                <tr>
                  <th class="px-4 py-2">Producto</th>
                  <th class="px-4 py-2 text-center">Cantidad</th>
                  <th class="px-4 py-2 text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <template x-for="item in pedidoSeleccionado.items" :key="item.product_id">
                  <tr>
                    <td class="px-4 py-2" x-text="item.name"></td>
                    <td class="px-4 py-2 text-center" x-text="item.quantity"></td>
                    <td class="px-4 py-2 text-right"
                        x-text="'COP ' + item.subtotal.toLocaleString()">
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </template>
</div>
@endsection