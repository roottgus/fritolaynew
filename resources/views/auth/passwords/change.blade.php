{{-- resources/views/auth/passwords/change.blade.php --}}
@extends('layouts.login-layout')

@section('form')
<div class="flex flex-col items-center">
    {{-- Logo superior --}}
    <img src="{{ asset('img/dyj.png') }}" alt="FritoLay" class="h-12 mb-4">

    <h2 class="text-2xl font-bold text-gray-900 mb-2">¡Bienvenido!</h2>
    <p class="text-gray-700 mb-6 text-center">Para continuar, ingresa tu contraseña temporal y define una nueva contraseña.</p>

    <form action="{{ route('password.update') }}" method="POST" class="w-full max-w-sm space-y-4">
        @csrf

        {{-- Contraseña temporal --}}
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Contraseña Temporal</label>
            <input
                id="current_password"
                type="password"
                name="current_password"
                required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            />
            @error('current_password')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        {{-- Nueva contraseña --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                minlength="8"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            />
            @error('password')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            />
        </div>

        {{-- Botón de actualización --}}
        <button
            type="submit"
            class="w-full py-2 rounded-lg bg-gradient-to-r from-yellow-400 to-red-600 text-white font-semibold hover:from-yellow-500 hover:to-red-700 transition"
        >
            Actualizar Contraseña
        </button>
    </form>
</div>
@endsection
