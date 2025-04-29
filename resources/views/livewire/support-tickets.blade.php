{{-- resources/views/livewire/support-tickets.blade.php --}}
<div class="space-y-6">

  {{-- Mensajes de feedback --}}
  @if (session()->has('supportSuccess'))
    <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
      {{ session('supportSuccess') }}
    </div>
  @endif
  @if (session()->has('supportError'))
    <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-600 text-red-800 rounded">
      {{ session('supportError') }}
    </div>
  @endif

  {{-- Descripción --}}
  <p class="text-gray-700 text-center">
    Bienvenido al portal de soporte. Crea tu ticket con categoría, prioridad y detalles. Nuestro equipo te responderá pronto.
  </p>

  {{-- Formulario --}}
  <form wire:submit.prevent="createTicket" class="space-y-4">

    <div class="grid grid-cols-2 gap-4">
      {{-- Categoría --}}
      <div>
        <label for="category_id" class="block text-sm font-medium text-gray-600 mb-1">Categoría</label>
        <select
          id="category_id"
          wire:model="categoryId"
          required
          class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FCDE3A] transition"
        >
          <option value="">Selecciona una categoría</option>
          @foreach(\App\Models\TicketCategory::all() as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
          @endforeach
        </select>
        @error('categoryId') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Prioridad --}}
      <div>
        <label for="priority" class="block text-sm font-medium text-gray-600 mb-1">Prioridad</label>
        <select
          id="priority"
          wire:model="priority"
          required
          class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d32a1e] transition"
        >
          <option value="low">Baja</option>
          <option value="medium">Media</option>
          <option value="high">Alta</option>
        </select>
        @error('priority') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Detalles --}}
    <div>
      <label for="details" class="block text-sm font-medium text-gray-600 mb-1">Detalles</label>
      <textarea
        id="details"
        wire:model="details"
        rows="4"
        placeholder="Describe tu consulta o problema..."
        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FCDE3A] transition"
      ></textarea>
      @error('details') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Botón Crear Ticket --}}
    <button
      type="submit"
      wire:loading.attr="disabled"
      class="w-full flex items-center justify-center px-4 py-3
             bg-gradient-to-r from-[#FCDE3A] via-[#FCAF17] to-[#d32a1e]
             text-white text-lg font-semibold rounded-lg shadow-2xl
             transform hover:scale-105 hover:shadow-2xl transition-all duration-300 ease-out"
    >
      <div wire:loading.remove class="inline-flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>Crear Ticket</span>
      </div>
      <span wire:loading>Creando...</span>
    </button>
  </form>

  {{-- Listado de tickets con scroll --}}
  <div class="max-h-80 overflow-y-auto">
    <ul class="space-y-4">
      @forelse($tickets as $ticket)
        <li class="flex justify-between items-center bg-white border border-gray-200 rounded-lg p-4 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200">
          <a href="{{ route('tickets.show', $ticket) }}"
             class="text-gray-800 font-medium hover:text-[#FCDE3A] transition">
            {{ $ticket->subject }}
          </a>
          <span class="px-3 py-1 text-sm font-semibold rounded-full
                       {{ $ticket->priority == 'high'   ? 'bg-red-100 text-red-800' :
                          ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' :
                                                           'bg-green-100 text-green-800') }}">
            {{ ucfirst($ticket->priority) }}
          </span>
        </li>
      @empty
        <li class="text-gray-500 italic text-center">Aún no tienes tickets creados.</li>
      @endforelse
    </ul>
  </div>

</div>
