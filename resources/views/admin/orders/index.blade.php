{{-- resources/views/admin/orders/index.blade.php --}}
@extends('layouts.admin')

@section('content')
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<div class="p-6" x-data>
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-semibold">📦 Gestión de Pedidos</h1>
    <a href="{{ route('admin.orders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
      + Nuevo Pedido
    </a>
  </div>

  @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Negocio</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origen</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ítems</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($orders as $order)
        <tr x-data="{ orderId: {{ $order->id }} }" class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->id }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($order->user)->establecimiento ?? '—' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">COP {{ number_format($order->total, 0, ',', '.') }}</td>

          {{-- Estado con mapeo Español/Inglés --}}
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            @php $st = mb_strtolower($order->status); @endphp
            @if(in_array($st, ['pendiente', 'pending']))
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-200 text-yellow-800">Pendiente</span>
            @elseif(in_array($st, ['completado', 'completed']))
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-200 text-green-800">Completado</span>
            @elseif(in_array($st, ['cancelado', 'canceled']))
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-200 text-red-800">Cancelado</span>
            @else
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-200 text-gray-800">{{ ucfirst($st) }}</span>
            @endif
          </td>

          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($order->origin) }}</td>
          <td class="px-6 py-4 text-sm text-gray-900">
            @php $itemsArr = is_string($order->items) ? json_decode($order->items, true) : $order->items; @endphp
            @if(is_array($itemsArr) && count($itemsArr))
              <ul class="list-disc list-inside space-y-1">
                @foreach($itemsArr as $item)
                  <li>{{ $item['name'] ?? '–' }} x {{ $item['quantity'] ?? '–' }}</li>
                @endforeach
              </ul>
            @else
              <span class="text-gray-400">—</span>
            @endif
          </td>

          {{-- Acciones mejoradas --}}
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
            <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition">
              <i class="fas fa-edit"></i>
              <span>Editar</span>
            </a>
            
            <button 
              @click.prevent="Swal.fire({
                title: `¿Eliminar pedido #${orderId}?`,
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                  confirmButton: 'bg-red-600 text-white px-4 py-1 rounded-md hover:bg-red-700',
                  cancelButton: 'bg-gray-200 text-gray-700 px-4 py-1 rounded-md hover:bg-gray-300'
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  $refs[`form${orderId}`].submit();
                }
              })"
              class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition">
              <i class="fas fa-trash-alt"></i>
              <span>Eliminar</span>
            </button>

            <form x-ref="form{{ $order->id }}" action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="hidden">
              @csrf
              @method('DELETE')
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $orders->links() }}
  </div>
</div>
@endsection
