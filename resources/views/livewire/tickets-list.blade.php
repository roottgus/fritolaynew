{{-- resources/views/livewire/tickets-list.blade.php --}}
<div>
  {{-- Pasos de Soporte (encabezado full width) --}}
  <div class="w-full bg-gradient-to-br from-blue-50 to-white rounded-lg shadow-lg border border-blue-100 px-4 py-6 space-y-4">
    <div class="text-center">
      <h2 class="text-2xl font-extrabold text-gray-800">¿Cómo funciona?</h2>
      <p class="text-gray-600 mt-1">Sigue estos sencillos pasos para obtener soporte rápido.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
      {{-- Paso 1 --}}
      <div class="flex flex-col items-center text-center space-y-2">
        <div class="p-4 bg-white rounded-full shadow-md">
          <i class="fas fa-comment fa-lg text-blue-500"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-700">1. Describe tu caso</h3>
        <p class="text-gray-600 text-sm">Cuéntanos qué sucede para entender tu necesidad.</p>
      </div>
      {{-- Paso 2 --}}
      <div class="flex flex-col items-center text-center space-y-2">
        <div class="p-4 bg-white rounded-full shadow-md">
          <i class="fas fa-headset fa-lg text-green-500"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-700">2. Recibe asistencia</h3>
        <p class="text-gray-600 text-sm">Nuestro equipo revisará y responderá en breve.</p>
      </div>
      {{-- Paso 3 --}}
      <div class="flex flex-col items-center text-center space-y-2">
        <div class="p-4 bg-white rounded-full shadow-md">
          <i class="fas fa-check-circle fa-lg text-red-500"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-700">3. Solución confirmada</h3>
        <p class="text-gray-600 text-sm">Cierra tu ticket cuando tu problema esté resuelto.</p>
      </div>
    </div>
  </div>

  {{-- Contenedor principal --}}
  <div class="max-w-5xl mx-auto p-6 space-y-6">
    {{-- Header: Título y botón --}}
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-extrabold text-gray-800">Mis Tickets de Soporte</h1>
      <button @click="$dispatch('open-support-modal')"
              class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-yellow-400 to-red-600
                     text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1
                     transition-all duration-200">
        <i class="fas fa-plus mr-2"></i> Crear Ticket
      </button>
    </div>

    {{-- Sección de tickets --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Sección de Tickets</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tickets as $ticket)
          <a href="{{ route('tickets.show', $ticket) }}"
             class="block bg-gray-50 rounded-xl shadow hover:shadow-md transform hover:-translate-y-1 transition-all duration-150">
            <div class="p-5 space-y-2">
              <div class="flex items-center justify-between">
                <span class="font-semibold text-gray-800">#{{ $ticket->id }} — {{ $ticket->subject }}</span>
                <span class="px-3 py-1 text-sm font-semibold rounded-full uppercase {{ $ticket->priority == 'high' ? 'bg-red-200 text-red-800' : ($ticket->priority == 'medium' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800') }}">
                  {{ ucfirst($ticket->priority) }}
                </span>
              </div>
              <div class="flex justify-between text-sm text-gray-500">
                <span><i class="far fa-clock mr-1"></i>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                <span><i class="far fa-comments mr-1"></i>{{ $ticket->messages->count() }} respuestas</span>
              </div>
            </div>
          </a>
        @empty
          <div class="col-span-full text-center text-gray-500 italic py-10">
            Todavía no has creado ningún ticket. Haz clic en "Crear Ticket" para empezar.
          </div>
        @endforelse
      </div>
    </div>

    {{-- Aviso informativo --}}
    <div class="max-w-3xl bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg p-4 ml-4">
      <div class="flex items-start space-x-3">
        <i class="fas fa-info-circle text-xl mt-1"></i>
        <p class="text-base">
          Recuerda que puedes responder desde aquí en cualquier momento. Nuestro equipo de soporte está disponible 24/7 y dará prioridad a los tickets de alta prioridad.
        </p>
      </div>
    </div>
  </div>
</div>
