{{-- resources/views/layouts/admin.blade.php --}}
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

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

  {{-- Toastr CSS --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body class="relative min-h-screen">

  {{-- Overlay semitransparente con la imagen de fondo --}}
  <div class="absolute inset-0 bg-cover bg-center opacity-30"
       style="background-image: url('{{ asset('img/background1.png') }}');">
  </div>

  {{-- Contenedor principal por encima del overlay --}}
  <div class="relative z-10 flex h-screen">

    {{-- SIDEBAR ADMIN --}}
    <aside class="sticky top-0 flex flex-col w-64 bg-gradient-to-b from-[#FCDE3A] to-[#d32a1e] text-white">
      <div class="p-6 flex items-center justify-center border-b border-white/50">
        <a href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('img/dyj.png') }}" alt="Logo" class="w-32">
        </a>
      </div>
      <nav class="flex flex-col mt-2">
        <a href="{{ url('admin/dashboard') }}"
           class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('admin/dashboard') ? 'bg-[#d32a1e] pl-8' : '' }}">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>

        {{-- Productos con submenú --}}
        <div x-data="{ openProducts: {{ request()->is('admin/products*') ? 'true' : 'false' }} }">
          <a href="#" @click.prevent="openProducts = !openProducts"
             class="py-3 px-6 flex items-center justify-between transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8"
             :class="openProducts ? 'bg-[#d32a1e] pl-8' : ''">
            <div class="flex items-center gap-2">
              <i class="fas fa-box"></i>
              <span>Productos</span>
            </div>
            <i :class="openProducts ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="text-sm"></i>
          </a>
          <ul x-show="openProducts" x-collapse class="bg-[#b91c1c] space-y-1 overflow-hidden">
            <li>
              <a href="{{ route('admin.products.index') }}"
                 class="block py-2 pl-12 text-sm text-white hover:bg-[#a21f1f] transition">
                Listar Productos
              </a>
            </li>
            <li>
              <a href="{{ route('admin.products.create') }}"
                 class="block py-2 pl-12 text-sm text-white hover:bg-[#a21f1f] transition">
                Nuevo Producto
              </a>
            </li>
            <li>
              <a href="{{ route('admin.categories.index') }}"
                 class="block py-2 pl-12 text-sm text-white hover:bg-[#a21f1f] transition">
                Categorías
              </a>
            </li>
          </ul>
        </div>

        {{-- Pedidos --}}
        <a href="{{ route('admin.orders.index') }}"
           class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('admin/orders*') ? 'bg-[#d32a1e] pl-8' : '' }}">
          <i class="fas fa-shopping-cart"></i>
          <span>Pedidos</span>
        </a>

        {{-- Usuarios --}}
        <a href="{{ route('admin.users.index') }}"
           class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('admin/users*') ? 'bg-[#d32a1e] pl-8' : '' }}">
          <i class="fas fa-users"></i>
          <span>Usuarios</span>
        </a>

        {{-- Anuncios --}}
        <a href="{{ route('admin.announcements.index') }}"
           class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('admin/announcements*') ? 'bg-[#d32a1e] pl-8' : '' }}">
          <i class="fas fa-bell"></i>
          <span>Anuncios</span>
        </a>

        {{-- Ofertas --}}
        <a href="{{ route('admin.offers.index') }}"
           class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('admin/offers*') ? 'bg-[#d32a1e] pl-8' : '' }}">
          <i class="fas fa-tag"></i>
          <span>Ofertas</span>
        </a>

        {{-- Tickets --}}
        <a href="{{ route('admin.tickets.index') }}"
           class="py-3 px-6 flex items-center gap-2 transition-all duration-200 hover:bg-[#d32a1e] hover:pl-8 {{ request()->is('admin/tickets*') ? 'bg-[#d32a1e] pl-8' : '' }}">
          <i class="fas fa-ticket-alt"></i>
          <span>Tickets</span>
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

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="flex-1 flex flex-col overflow-y-auto">

      {{-- NAVBAR --}}
      @include('partials.navbar')

      {{-- SECCIÓN DE CONTENIDO --}}
      <main class="p-6 flex-1 bg-white/80">
        @yield('content')
      </main>

      {{-- FOOTER --}}
      @include('partials.footer')
    </div>
  </div>

  {{-- Chart.js CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  {{-- Scripts de Vite --}}
  @vite('resources/js/app.js')

  {{-- jQuery (requisito de Toastr) --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  {{-- Toastr JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  {{-- Livewire Scripts --}}
  @livewireScripts

  {{-- Polling JS: revisa cada 3s el contador y muestra toast si sube --}}
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