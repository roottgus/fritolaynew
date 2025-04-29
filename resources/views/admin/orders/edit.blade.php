<?php /* resources/views/admin/orders/edit.blade.php */ ?>
@extends('layouts.admin')

@section('content')
@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

<div class="max-w-5xl mx-auto p-6 space-y-8" x-data="{ status: @js($order->status) }">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-orange-500 to-red-700 p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-white">✏️ Editar Pedido <span class="font-mono">#{{ $order->id }}</span></h1>
        <p class="mt-1 text-blue-100">Fecha: {{ $order->created_at->format('d M Y H:i') }}</p>
    </div>

    {{-- Información del Cliente --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-700">Negocio / Cliente</h2>
            <p class="mt-1 text-gray-900">{{ $order->user->establecimiento ?? '–' }}</p>
            <p class="mt-2 text-sm text-gray-600">Email: {{ $order->user->email ?? '–' }}</p>
        </div>
        <div>
            <h2 class="text-lg font-medium text-gray-700">Contacto</h2>
            <p class="mt-1 text-gray-900">Teléfono: {{ $order->user->telefono ?? '–' }}</p>
            <p class="mt-2 text-sm text-gray-600">Origen original: <span class="capitalize">{{ $order->origin }}</span></p>
        </div>
    </div>

    {{-- Formulario de edición --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total --}}
                <div>
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-1">Total (COP)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="total"
                        id="total"
                        value="{{ old('total', $order->total) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    @error('total') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Origen Select --}}
                <div>
                    <label for="origin" class="block text-sm font-medium text-gray-700 mb-1">Origen</label>
                    <select
                        id="origin"
                        name="origin"
                        class="w-full border border-gray-300 rounded px-3 py-2 transition-shadow duration-150 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="web" {{ old('origin', $order->origin)==='web' ? 'selected' : '' }}>Web</option>
                        <option value="vendedor" {{ old('origin', $order->origin)==='vendedor' ? 'selected' : '' }}>Vendedor</option>
                    </select>
                    @error('origin') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Estado dinámico --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select
                        x-model="status"
                        name="status"
                        id="status"
                        :class="{
                            'bg-yellow-100 text-yellow-800': status === 'pending',
                            'bg-green-100 text-green-800' : status === 'completed',
                            'bg-red-100 text-red-800'     : status === 'canceled',
                            'bg-white text-gray-900'      : !['pending','completed','canceled'].includes(status)
                        }"
                        class="w-full border border-gray-300 rounded px-3 py-2 transition-colors duration-150 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="pending">Pendiente</option>
                        <option value="completed">Completado</option>
                        <option value="canceled">Cancelado</option>
                    </select>
                    @error('status') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Ítems Detallados --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ítems del Pedido</label>
                @php
                    $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                @endphp
                <div class="overflow-x-auto bg-gray-50 border border-gray-200 rounded-md">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Nombre</th>
                                <th class="px-4 py-2 text-center">Cantidad</th>
                                <th class="px-4 py-2 text-right">Precio Unitario</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($items as $item)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $item['name'] ?? '–' }}</td>
                                    <td class="px-4 py-2 text-center">{{ $item['quantity'] ?? '–' }}</td>
                                    <td class="px-4 py-2 text-right">COP {{ number_format($item['unit_price'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">COP {{ number_format($item['subtotal'] ?? ($item['quantity'] * $item['unit_price']), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-gray-500 italic">Sin ítems registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-indigo-700 transition">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
