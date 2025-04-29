{{-- resources/views/partials/navbar.blade.php --}}
<nav class="bg-white dark:bg-gray-800 p-4 shadow-md flex justify-between items-center">
  {{-- Izquierda: Logo + enlaces --}}
  <div class="flex items-center space-x-6">
    <a href="{{ route('inicio') }}" class="flex items-center">
      <img src="{{ asset('img/dyj.png') }}" alt="Logo" class="h-8">
      <span class="ml-2 text-xl font-semibold text-gray-800 dark:text-white">D&amp;J Distribuciones</span>
    </a>
    <a href="{{ url('/') }}"       class="text-gray-700 dark:text-gray-300 hover:text-gray-900"></a>
    <a href="{{ url('/productos') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900"></a>
    <a href="{{ url('/pedidos') }}"    class="text-gray-700 dark:text-gray-300 hover:text-gray-900"></a>
  </div>

  {{-- Derecha: Notificaciones, Carrito, Perfil --}}
  <div class="flex items-center space-x-6">
    {{-- Notificaciones --}}
    <livewire:notification-bell />

    {{-- Carrito --}}
    <button aria-label="Carrito de Compras"
            onclick="window.location.href='{{ url('/pedidos') }}'"
            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 transition-transform duration-200 hover:scale-110">
      <i class="fas fa-shopping-cart w-6 h-6"></i>
    </button>

    {{-- Perfil / Cerrar sesión --}}
    <div class="flex items-center space-x-2">
      <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dddddd&color=555555"
           alt="Avatar" class="w-8 h-8 rounded-full">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-gray-700 dark:text-gray-300 hover:text-gray-900">Salir</button>
      </form>
    </div>
  </div>
</nav>

