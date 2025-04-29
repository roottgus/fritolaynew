<div wire:poll.5000ms="loadNotifications"
     class="relative"
     x-data="{ open: false }"
     @click.outside="open = false"
>
    {{-- Campanita --}}
    <button @click="open = !open"
            class="relative focus:outline-none text-gray-700 hover:text-gray-900">
        <i class="fas fa-bell text-2xl"></i>

        {{-- Badge siempre presente para el polling JS --}}
        @if($unreadCount)
            <span id="notif-count"
                  class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full
                         h-5 w-5 flex items-center justify-center text-xs">
                {{ $unreadCount }}
            </span>
        @else
            <span id="notif-count" class="hidden"></span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div x-cloak x-show="open" x-transition
         class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl overflow-hidden z-50">
        <div class="px-6 py-4 bg-gradient-to-r from-orange-400 via-orange-500 to-red-600">
            <h3 class="text-lg font-bold text-white">Notificaciones</h3>
        </div>
        <ul class="max-h-64 overflow-y-auto">
            @forelse($notifications as $note)
                <li class="flex justify-between items-start px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex-1">
                        <div class="border-l-4 {{ $note->read_at ? 'border-gray-300' : 'border-orange-500' }} pl-4">
                            <p class="text-gray-800 font-medium leading-snug">
                                {{ $note->data['message'] ?? 'Tienes una nueva notificación' }}
                            </p>
                            <small class="text-orange-400 mt-1 block">
                                {{ $note->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    @if(! $note->read_at)
                        <button wire:click="markAsRead('{{ $note->id }}')"
                                class="ml-4 text-blue-600 text-sm hover:underline">
                            Marcar leído
                        </button>
                    @endif
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500 italic">
                    No tienes notificaciones.
                </li>
            @endforelse
        </ul>
        <div class="px-6 py-3 bg-gradient-to-r from-orange-400 via-orange-500 to-red-600 flex justify-between items-center">
            <a href="#" wire:click.prevent="markAllAsRead"
               class="text-white font-medium hover:underline text-sm">
              Marcar todas como leídas
            </a>
            <span class="text-gray-200 text-xs">{{ $unreadCount }} sin leer</span>
        </div>
    </div>
</div>
