<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'FritoLay') }}</title>

  {{-- Tailwind CSS y Alpine defer --}}
  @vite('resources/css/app.css')
  <script>window.deferLoadingAlpine = true;</script>

  {{-- Livewire Styles --}}
  @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ chatOpen: false }" x-on:close-chat.window="chatOpen = false">

  {{-- Navbar (incluye partial del chat) --}}
  @include('partials.navbar')

  {{-- Header Global --}}
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-blue-600">{{ config('app.name', 'FritoLay') }}</h1>
      <nav>
        <ul class="flex space-x-4">
          <li><a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">Inicio</a></li>
          <li><a href="{{ url('/productos') }}" class="text-gray-700 hover:text-blue-600">Productos</a></li>
          <li><a href="{{ url('/pedidos') }}" class="text-gray-700 hover:text-blue-600">Pedidos</a></li>
          @auth
            <li><button @click="chatOpen = true" class="text-gray-700 hover:text-blue-600">Soporte</button></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600">Cerrar Sesión</button>
              </form>
            </li>
          @else
            <li><a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Iniciar Sesión</a></li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>

  {{-- Contenido principal --}}
  <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('partials.footer')

  {{-- JS Bundle (Alpine, Livewire, Chart.js, etc.) --}}
  @vite('resources/js/app.js')

  {{-- Livewire Scripts --}}
  @livewireScripts

  
</body>
</html>
