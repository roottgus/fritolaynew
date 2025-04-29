{{-- resources/views/inicio.blade.php --}}
@extends('layouts.app-user')

@section('content')
<div
  x-data='{
    // Control de modal de soporte
    openSupport: false,

    // Control de modal de actualizar datos
    openUpdate: false,

    // Carousel de anuncios
    announcements: @json($announcements),
    activeIndex: 0
  }'
  x-init='
    if (announcements.length > 0) {
      setInterval(function(){
        activeIndex = (activeIndex + 1) % announcements.length
      }, 3000)
    }
  '
  x-cloak
  class="relative"
>

  <!-- Contenedor Superior: Bienvenida + Tarjetas de Resumen -->
  <section class="mb-6 p-6 bg-blue-50 rounded-lg shadow flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="md:w-1/2">
      <h1 class="text-3xl font-bold text-blue-900">
        Bienvenido(a) {{ auth()->user()->name ?? 'Invitado' }}
      </h1>
      <p class="mt-2 text-blue-700">
        Aquí encontrarás un resumen de tu cuenta y tus pedidos recientes.
      </p>
    </div>
    <div class="md:w-1/2 flex justify-end">
      @include('partials.summary-cards', ['orders' => $orders])
    </div>
  </section>

  <!-- Acceso Rápido con Íconos -->
  <section class="mb-6 p-4 bg-white/80 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-blue-900 mb-4">Acceso Rápido</h2>
    <div class="flex flex-wrap gap-4 justify-center">
      <button onclick="location.href='{{ url('pedidos') }}'"
              class="flex items-center gap-2 px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition">
        <i class="fas fa-shopping-cart"></i>
        <span>Realizar Pedido</span>
      </button>
      <button onclick="location.href='{{ url('mi-cuenta') }}'"
              class="flex items-center gap-2 px-4 py-2 bg-pink-500 text-white font-semibold rounded-lg shadow hover:bg-pink-600 transition">
        <i class="fas fa-history"></i>
        <span>Historial de Pedidos</span>
      </button>
      <button @click="openUpdate = true"
              class="flex items-center gap-2 px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow hover:bg-orange-600 transition">
        <i class="fas fa-user-edit"></i>
        <span>Actualizar Datos</span>
      </button>
      <button
        @click="openSupport = true"
        class="flex items-center gap-2 px-4 py-2 bg-teal-500 text-white font-semibold rounded-lg shadow hover:bg-teal-600 transition"
      >
        <i class="fas fa-headset"></i>
        <span>Soporte</span>
      </button>
    </div>
  </section>

  {{-- Modal de Soporte --}}
  <div
    x-show="openSupport"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center overflow-auto"
  >
    {{-- Fondo semitransparente --}}
    <div class="fixed inset-0 bg-black/75 z-40" @click="openSupport = false"></div>

    {{-- Ventana modal --}}
    <div class="relative bg-white rounded-lg shadow-lg overflow-hidden w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2 xl:w-1/3 z-50">
      <div class="flex justify-between items-center bg-gradient-to-r from-[#FCDE3A] via-[#FCAF17] to-[#d32a1e] p-4">
        {{-- Logo de la empresa --}}
        <div class="flex items-center gap-2">
          <img src="{{ asset('img/dyj.png') }}" alt="D&J Distribuciones" class="h-8 w-auto">
          <h3 class="text-lg font-semibold text-white">Soporte D&amp;J Distribuciones</h3>
        </div>
        <button @click="openSupport = false" class="text-white text-2xl hover:opacity-75">&times;</button>
      </div>
      <div class="p-6">
        <livewire:support-tickets />
      </div>
    </div>
  </div>

  {{-- Novedades y Anuncios --}}
  <section class="mb-6 p-4 bg-gray-200 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-blue-900 mb-4">Novedades y Anuncios</h2>

    <template x-if="announcements.length > 0">
      <div class="p-4 bg-white rounded-lg shadow flex items-center gap-4 transition-all duration-700">
        <i :class="announcements[activeIndex].icon" class="text-2xl"></i>
        <div>
          <h3 class="text-xl font-semibold text-gray-800"
              x-text="announcements[activeIndex].title"></h3>
          <p class="text-gray-700 mt-2"
             x-text="announcements[activeIndex].text"></p>
        </div>
      </div>
    </template>

    <template x-if="announcements.length === 0">
      <p class="text-gray-700">No hay anuncios.</p>
    </template>
  </section>

  <!-- Síguenos en Redes -->
  <section class="mb-6">
    <h2 class="text-xl font-bold text-blue-900 mb-4">Síguenos en Redes</h2>
    <div class="flex gap-4 text-2xl">
      <a href="https://www.facebook.com" target="_blank" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook"></i></a>
      <a href="https://www.instagram.com" target="_blank" class="text-pink-500 hover:text-pink-700"><i class="fab fa-instagram"></i></a>
      <a href="https://www.twitter.com" target="_blank" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
    </div>
  </section>

  {{-- Modal de Actualizar Datos --}}
  @include('partials.actualizar-datos-modal')

  <!-- Ofertas Especiales -->
  <div class="mt-12">
    @include('partials.offers')
  </div>

</div>
@endsection