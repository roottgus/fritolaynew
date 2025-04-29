{{-- resources/views/layouts/app-user.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ config('app.name', 'FritoLay') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Livewire Styles --}}
  @livewireStyles

  {{-- Tailwind CSS compilado por Vite --}}
  @vite('resources/css/app.css')

  {{-- Font Awesome --}}
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  {{-- Toastr CSS --}}
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body
  class="h-screen flex overflow-hidden bg-gray-100"
  x-data="{ chatOpen: false }"
  x-on:close-chat.window="chatOpen = false"
>
  <!-- Sidebar lateral -->
  <aside class="sticky top-0 flex flex-col w-64 bg-gradient-to-b from-[#FCDE3A] to-[#d32a1e] text-white">
    <div class="p-6 flex items-center justify-center border-b border-white/50">
      <img src="{{ asset('img/dyj.png') }}" alt="Logo" class="w-32">
    </div>
    <nav class="flex flex-col mt-2">
      <a href="{{ route('inicio') }}"
         class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('inicio') ? 'bg-[#d32a1e] pl-8' : '' }}">
        <i class="fas fa-home"></i>
        <span>Inicio</span>
      </a>
      <a href="{{ url('/pedidos') }}"
         class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('pedidos') ? 'bg-[#d32a1e] pl-8' : '' }}">
        <i class="fas fa-box"></i>
        <span>Pedidos</span>
      </a>
      <a href="{{ url('/mi-cuenta') }}"
         class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('mi-cuenta') ? 'bg-[#d32a1e] pl-8' : '' }}">
        <i class="fas fa-user"></i>
        <span>Mi Cuenta</span>
      </a>
      <a href="{{ route('tickets.index') }}"
         class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('tickets') ? 'bg-[#d32a1e] pl-8' : '' }}">
        <i class="fas fa-ticket-alt"></i>
        <span>Tickets-Soporte</span>
      </a>
    </nav>
    <div class="p-6 border-t border-white/50">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="w-full bg-[#eea924] hover:bg-[#d32a1e] py-2 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
          <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
        </button>
      </form>
    </div>
    <footer class="p-4 border-t border-white text-center text-xs text-gray-200">
      © {{ date('Y') }} Todos los derechos reservados.
    </footer>
  </aside>

  <!-- Contenido principal -->
  <div class="flex-1 flex flex-col overflow-y-auto relative">
    {{-- Navbar con componente de notificaciones --}}
    @include('partials.navbar')

    <main class="p-6 flex-1">
      @isset($slot)
        {{ $slot }}
      @else
        @yield('content')
      @endisset
    </main>

    @include('partials.footer')
  </div>

  {{-- Vite JS --}}
  @vite('resources/js/app.js')

  {{-- jQuery (necesario para Toastr) --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  {{-- Toastr JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  {{-- Livewire Scripts --}}
  @livewireScripts

  {{-- Polling JS: cada 3s compara el badge y muestra toast si sube --}}
  <script>
    $(function() {
      let oldCount = parseInt($('#notif-count').text()) || 0;
      setInterval(() => {
        const current = parseInt($('#notif-count').text()) || 0;
        if (current > oldCount) {
          const diff = current - oldCount;
          toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '5000'
          };
          toastr.info(`Tienes ${diff} nueva(s) notificación(es)`);
        }
        oldCount = current;
      }, 3000);
    });
  </script>

  @stack('scripts')
</body>
</html>
