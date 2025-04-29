{{-- resources/views/vendor/filament/components/layouts/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ config('app.name', 'FritoLay - Admin') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Livewire Styles --}}
  @livewireStyles

  {{-- Tailwind CSS compilado por Vite --}}
  @vite('resources/css/app.css')

  {{-- Estilos de Filament --}}
  @filamentStyles

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
</head>
<body class="relative min-h-screen">

  {{-- Overlay semitransparente con imagen de fondo --}}
  <div class="absolute inset-0 bg-cover bg-center opacity-30"
       style="background-image: url('{{ asset('img/background1.png') }}');">
  </div>

  {{-- Contenedor principal --}}
  <div class="relative z-10 flex h-screen">

    {{-- SIDEBAR ADMIN personalizado --}}
    <aside class="sticky top-0 flex flex-col w-64 bg-gradient-to-b from-[#FCDE3A] to-[#d32a1e] text-white">
      <div class="p-6 flex items-center justify-center border-b border-white/50">
        <a href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('img/dyj.png') }}" alt="Logo" class="w-32">
        </a>
      </div>
      <nav class="flex flex-col mt-2">
  <a
    href="{{ route('admin.dashboard') }}"
    class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->routeIs('admin.dashboard') ? 'bg-[#d32a1e] pl-8' : '' }}"
  >
    <i class="fas fa-home"></i><span>Dashboard</span>
  </a>
  <a
    href="{{ route('admin.products.index') }}"
    class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->routeIs('admin.products.*') ? 'bg-[#d32a1e] pl-8' : '' }}"
  >
    <i class="fas fa-box"></i><span>Productos</span>
  </a>
  <a
    href="{{ route('admin.orders.index') }}"
    class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->routeIs('admin.orders.*') ? 'bg-[#d32a1e] pl-8' : '' }}"
  >
    <i class="fas fa-shopping-cart"></i><span>Pedidos</span>
  </a>
  <a
    href="{{ route('admin.users.index') }}"
    class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->routeIs('admin.users.*') ? 'bg-[#d32a1e] pl-8' : '' }}"
  >
    <i class="fas fa-users"></i><span>Usuarios</span>
  </a>
  <a
    href="{{ route('admin.announcements.index') }}"
    class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->routeIs('admin.announcements.*') ? 'bg-[#d32a1e] pl-8' : '' }}"
  >
    <i class="fas fa-bell"></i><span>Anuncios</span>
  </a>
  <a
    href="{{ route('admin.offers.index') }}"
    class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->routeIs('admin.offers.*') ? 'bg-[#d32a1e] pl-8' : '' }}"
  >
    <i class="fas fa-tag"></i><span>Ofertas</span>
  </a>
  <a href="{{ url('admin/tickets') }}"
   class="py-3 px-6 … {{ request()->is('admin/tickets*') ? 'bg-[#d32a1e] pl-8' : '' }}">
  <i class="fas fa-ticket-alt"></i><span>Tickets</span>
</a>

</nav>

      <div class="p-6 border-t border-white/50">
        <form method="POST" action="{{ route('logout') }}">
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

    {{-- CONTENIDO PRINCIPAL DE FILAMENT --}}
    <div class="flex-1 flex flex-col overflow-y-auto">

      {{-- Navbar de usuario (puedes incluir tu partial si lo usas) --}}
      @includeWhen(View::exists('partials.navbar'), 'partials.navbar')

      {{-- Aquí Filament inyecta cada página --}}
      <main class="p-6 flex-1 bg-white/80">
        {{ \$slot }}
      </main>

      {{-- Footer (partial) --}}
      @includeWhen(View::exists('partials.footer'), 'partials.footer')
    </div>
  </div>

  {{-- Chart.js CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  {{-- Scripts de la app y de Filament --}}
  @vite('resources/js/app.js')
  @livewireScripts
  @filamentScripts
  @stack('scripts')
</body>
</html>
