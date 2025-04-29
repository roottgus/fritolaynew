<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{ config('app.name', 'FritoLay') }}</title>

  {{-- CSS y Alpine --}}
  @vite('resources/css/app.css')
  @livewireStyles
  
  <script>window.deferLoadingAlpine = true;</script>
</head>
<body class="relative min-h-screen bg-cover bg-center" 
      style="background-image: url('{{ asset('img/background1.png') }}');">

  {{-- Oscurecimiento --}}
  <div class="absolute inset-0 bg-black/50"></div>

  {{-- Contenedor central --}}
  <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-4xl bg-white/30 backdrop-blur-lg rounded-3xl overflow-hidden shadow-xl flex flex-col md:flex-row">
      <!-- Columna Izquierda -->
      <div class="w-full md:w-1/2 p-8 text-white flex flex-col justify-center space-y-6">
        <h1 class="text-4xl font-bold">¡Bienvenido!</h1>
        <p class="text-xl">Por favor, ingresa tus credenciales para acceder a tu cuenta, realizar pedidos y consultar promociones exclusivas.</p>
        
      </div>
      <!-- Columna Derecha -->
      <div class="w-full md:w-1/2 p-8 bg-white/80">
        @yield('form')
      </div>
    </div>
  </div>

  {{-- Footer --}}
  <footer class="absolute bottom-6 left-0 right-0 z-10 text-center">
    @include('partials.footer')
  </footer>

  {{-- Scripts --}}
  @livewireScripts
  @vite('resources/js/app.js')
  
</body>
</html>