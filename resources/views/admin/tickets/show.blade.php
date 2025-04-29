{{-- resources/views/admin/tickets/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-gray-50 min-h-screen space-y-8">
    {{-- Encabezado del Ticket --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-600">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">{{ $ticket->subject }}</h1>
            <div class="space-x-2 flex items-center">
                {{-- Estado del ticket --}}
                <span
                    class="inline-block px-3 py-1 text-sm font-medium rounded-full
                        @if($ticket->status == 'new') bg-yellow-100 text-yellow-800
                        @elseif($ticket->status == 'in_progress') bg-blue-100 text-blue-800
                        @elseif($ticket->status == 'closed') bg-green-100 text-green-800
                        @endif"
                >
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>

                {{-- Botón Cerrar Ticket si no está cerrado --}}
                @if($ticket->status !== 'closed')
                    <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition ml-2">
                            <i class="fas fa-lock mr-2"></i>
                            Cerrar Ticket
                        </button>
                    </form>
                @endif

                {{-- Fecha de creación --}}
                <span class="text-gray-500 text-sm">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- Detalles del ticket --}}
    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-800">Detalles del Ticket</h2>
        <p><strong>Categoría:</strong> {{ $ticket->category->name ?? 'No asignada' }}</p>
        <p><strong>Prioridad:</strong> <span class="capitalize">{{ $ticket->priority }}</span></p>
    </div>

    {{-- Mensaje inicial del usuario --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-md font-semibold text-gray-800 mb-3">Mensaje del Usuario</h3>
        <div class="flex justify-start">
            <div class="max-w-3xl w-full p-4 rounded-lg shadow border-l-4 border-gray-300 bg-gray-100 text-gray-800">
                <div class="flex items-center mb-2">
                    <span class="font-medium">{{ $ticket->user->name }}</span>
                    <span class="ml-4 text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</span>
                </div>
                <p class="whitespace-pre-wrap">{{ $ticket->message }}</p>
            </div>
        </div>
    </div>

    {{-- Hilo de Mensajes con scroll --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-md font-semibold text-gray-800 mb-4">Conversación</h3>
        <div class="max-h-80 overflow-y-auto space-y-6">
            @foreach($ticket->messages as $msg)
                <div class="flex {{ $msg->user_id == $ticket->user_id ? 'justify-start' : 'justify-end' }}">
                    <div class="max-w-3xl w-full p-4 rounded-lg shadow border-l-4
                        {{ $msg->user_id == $ticket->user_id
                            ? 'border-gray-300 bg-gray-100 text-orange-600'
                            : 'border-blue-500 bg-green-100 text-black' }}">
                        <div class="flex items-center mb-2">
                            <span class="font-medium">{{ $msg->user->name }}</span>
                            <span class="ml-4 text-xs {{ $msg->user_id == $ticket->user_id ? 'text-gray-500' : 'text-indigo-200' }}">
                                {{ $msg->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="whitespace-pre-wrap">{{ $msg->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Formulario de respuesta --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-md font-semibold text-gray-800 mb-3">Responder</h3>
        <form action="{{ route('admin.tickets.messages.store', $ticket) }}" method="POST">
            @csrf
            <textarea name="body" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-400 focus:border-green-400 transition"
                      placeholder="Escribe tu respuesta aquí..."></textarea>
            @error('body')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div class="mt-4 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-orange-600 text-white font-semibold rounded-md hover:bg-red-700 transition">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Respuesta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection