@extends('layouts.login-layout')

@section('form')
<div x-data="{ showForgotModal: false }" class="w-full max-w-sm mx-auto">
  <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg p-6">
    {{-- Logo --}}
    <div class="flex justify-center mb-4">
      <img src="{{ asset('img/dyj.png') }}"
           alt="Logo Empresa"
           class="h-16 w-16 object-contain" />
    </div>

    {{-- Formulario --}}
    <form action="{{ route('login.perform') }}" method="POST" class="space-y-4">
      @csrf

      {{-- Email --}}
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
        <div class="mt-1 flex items-center bg-gray-100 border border-gray-300 rounded-lg px-3 py-2">
          <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2.94 6.94a1 1 0 011.06-.27L10 9.18l5.99-2.51a1 1 0 111 .89v6.73a1 1 0 01-1 1H3a1 1 0 01-1-1V7.56a1 1 0 01.94-.62z"/>
          </svg>
          <input id="email" type="email" name="email" value="{{ old('email') }}"
                 required autofocus placeholder="correo@ejemplo.com"
                 class="ml-2 w-full bg-transparent outline-none text-sm" />
        </div>
        @error('email')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Contraseña --}}
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
        <div class="mt-1 flex items-center bg-gray-100 border border-gray-300 rounded-lg px-3 py-2">
          <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M5 8V6a5 5 0 1110 0v2h1a1 1 0 011 1v8a1 1 0 01-1 1H4a1 1 0 01-1-1v-8a1 1 0 011-1h1zm2-2a3 3 0 116 0v2H7V6z"
                  clip-rule="evenodd" />
          </svg>
          <input id="password" type="password" name="password"
                 required placeholder="••••••••"
                 class="ml-2 w-full bg-transparent outline-none text-sm" />
        </div>
        @error('password')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Olvidaste tu contraseña --}}
      <div class="text-right">
        <button type="button"
                @click="showForgotModal = true"
                class="text-xs text-red-600 hover:underline">
          ¿Olvidaste tu contraseña?
        </button>
      </div>

      {{-- Botón de login --}}
      <div>
      <button type="submit"
        class="w-full py-2 text-sm font-semibold rounded-lg text-white
               bg-gradient-to-r from-orange-500 to-red-600
               hover:from-orange-500 hover:to-red-700
               transition-shadow shadow-md hover:shadow-lg">
  Iniciar sesión
</button>

      </div>
    </form>
  </div>

  {{-- Modal de recuperación profesional --}}
  <div x-show="showForgotModal" x-cloak
       class="fixed inset-0 flex items-center justify-center bg-black/75 z-30"
       x-transition.opacity>
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-xs relative p-6">
      {{-- Cerrar --}}
      <button @click="showForgotModal = false"
              class="absolute top-3 right-3 text-gray-600 hover:text-gray-800 text-xl">
        &times;
      </button>

      {{-- Logo de empresa --}}
      <div class="flex justify-center mb-4">
        <img src="{{ asset('img/dyj.png') }}" alt="Logo" class="h-12 w-12 object-contain" />
      </div>

      {{-- Icono de advertencia --}}
      <div class="flex justify-center mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.29 3.86L1.82 18a1 1 0 00.86 1.5h18.64a1 1 0 00.86-1.5L13.71 3.86a1 1 0 00-1.72 0zM12 9v4m0 4h.01" />
        </svg>
      </div>

      {{-- Título y texto --}}
      <h3 class="text-center text-xl font-bold mb-2">Recuperar contraseña</h3>
      <p class="text-center text-gray-600 mb-6">
        Para recuperar tu contraseña, comunícate con nuestro equipo de soporte.
      </p>

      {{-- Botón WhatsApp --}}
      <div class="text-center">
        <a href="https://wa.me/1234567890?text=Necesito%20recuperar%20mi%20contraseña"
           target="_blank"
           class="inline-block w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
          <i class="fab fa-whatsapp mr-2"></i>Contactar por WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>
@endsection