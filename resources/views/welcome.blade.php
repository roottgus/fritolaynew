@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Sección de tarjetas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tarjeta de bienvenida -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Bienvenido a FritoLay</h2>
            <p class="text-gray-600">Gestiona tus pedidos y consulta estadísticas de forma rápida y sencilla.</p>
            <a href="/productos" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Ver Productos
            </a>
        </div>
    </div>

    <!-- Banner publicitario -->
    <div class="mt-8">
        <img src="{{ asset('img/banner.jpg') }}" alt="Banner publicitario" class="w-full rounded-lg shadow">
    </div>

    <!-- Sección de chat público -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Chat en Vivo</h2>
        @livewire('chat-component')
    </div>
</div>
@endsection