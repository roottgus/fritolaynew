{{-- resources/views/livewire/ticket-thread.blade.php --}}
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
  {{-- Conversación y chat --}}
  <div class="max-w-4xl mx-auto mt-12 space-y-6">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

      {{-- Header de chat --}}
      <div class="bg-gradient-to-r from-yellow-400 to-red-600 px-6 py-4 flex items-center justify-between">
        <span class="text-white text-xl font-semibold">Soporte D&amp;J</span>
        <button onclick="history.back()" class="text-white hover:text-gray-200">
          <i class="fas fa-arrow-left fa-lg"></i>
        </button>
      </div>

      {{-- Detalles ticket --}}
      <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-2 bg-gray-50">
        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">{{ $ticket->category->name }}</span>
        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full capitalize">{{ $ticket->priority }}</span>
        <span class="ml-auto text-gray-500 text-sm">Creado: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
      </div>

      {{-- Hilo de mensajes con scroll --}}
      <div class="px-6 py-4 bg-gray-50 space-y-4" style="max-height: 400px; overflow-y: auto;">
        <h2 class="text-lg font-semibold text-gray-700">Conversación</h2>

        {{-- Mensaje inicial --}}
        @if($ticket->message)
          <div class="flex justify-start">
            <div class="max-w-3/5 p-4 mb-4 rounded-2xl shadow bg-white text-gray-800">
              <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-sm">{{ $ticket->user->name }}</span>
                <span class="text-xs text-gray-500">{{ $ticket->created_at->format('d/m H:i') }}</span>
              </div>
              <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $ticket->message }}</p>
            </div>
          </div>
        @endif

        {{-- Respuestas --}}
        @foreach($messages as $msg)
          <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-3/5 p-4 rounded-2xl shadow {{ $msg->user_id === auth()->id() ? 'bg-yellow-100 text-gray-900 text-right' : 'bg-white text-gray-800 text-left' }}">
              <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-sm">{{ $msg->user->name }}</span>
                <span class="text-xs text-gray-500">{{ $msg->created_at->format('d/m H:i') }}</span>
              </div>
              <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->body }}</p>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Formulario de respuesta --}}
      <div class="px-6 py-6 bg-white">
        <form wire:submit.prevent="sendMessage" class="space-y-4">
          <textarea wire:model.defer="body"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-400 transition"
                    placeholder="Escribe tu mensaje aquí..."
                    required></textarea>
          @error('body')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
          <button type="submit"
                  class="w-full inline-flex justify-center items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-lg hover:bg-red-700 transition">
            <i class="fas fa-paper-plane mr-2"></i> Enviar Respuesta
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
