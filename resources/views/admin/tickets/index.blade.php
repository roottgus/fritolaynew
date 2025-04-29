{{-- resources/views/admin/tickets/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Tickets</h1>
        <a href="{{ route('admin.tickets.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 transition">
            <i class="fas fa-plus"></i>
            Nuevo Ticket
        </a>
    </div>

    {{-- Mensaje de Éxito --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de Tickets --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Asunto</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioridad</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ticket->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($ticket->subject, 40) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ticket->user->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 inline-flex text-xs font-semibold leading-5 rounded-full
                                @if($ticket->status == 'new') bg-yellow-100 text-yellow-800
                                @elseif($ticket->status == 'in_progress') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif capitalize">
                                {{ str_replace('_', ' ', $ticket->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 inline-flex text-xs font-semibold leading-5 rounded-full
                                @if($ticket->priority == 'low') bg-gray-100 text-gray-800
                                @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif capitalize">
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $ticket->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-center space-x-2">
                            <a href="{{ route('admin.tickets.show', $ticket) }}"
                               class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <button type="button"
                                    onclick="confirm('¿Eliminar ticket #{{ $ticket->id }}? Esta acción es irreversible.') && document.getElementById('delete-form-{{ $ticket->id }}').submit()"
                                    class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 transition">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                            <form id="delete-form-{{ $ticket->id }}"
                                  action="{{ route('admin.tickets.destroy', $ticket) }}"
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
