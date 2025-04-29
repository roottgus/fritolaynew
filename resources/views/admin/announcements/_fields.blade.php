{{-- resources/views/admin/announcements/_fields.blade.php --}}

@php
    // Definición de iconos disponibles
    $iconOptions = [
        'fas fa-info-circle',
        'fas fa-bell',
        'fas fa-exclamation-triangle',
        'fas fa-star',
        'fas fa-check-circle',
        'fas fa-bolt',
        'fas fa-heart',
        'fas fa-bullhorn',
    ];
@endphp

<div x-data="{ selectedIcon: '{{ old('icon', $announcement->icon ?? '') }}' }" x-cloak class="space-y-4">
    {{-- Selector de icono --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Seleccionar icono <span class="text-red-500">*</span></label>
        <input type="hidden" name="icon" x-model="selectedIcon" required />
        <div class="grid grid-cols-4 gap-2">
            @foreach($iconOptions as $icon)
                <div
                    @click="selectedIcon = '{{ $icon }}'"
                    :class="selectedIcon === '{{ $icon }}'
                        ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white'
                        : 'bg-white border border-gray-200 text-gray-600'"
                    class="flex items-center justify-center p-2 rounded cursor-pointer hover:shadow transition"
                    title="{{ ucwords(str_replace(['fas fa-', '-'], ['', ' '], $icon)) }}"
                >
                    <i :class="'{{ $icon }} text-xl'"></i>
                </div>
            @endforeach
        </div>
        @error('icon')
            <p class="mt-1 text-red-600 text-xs">{{ $message }}</p>
        @enderror
    </div>

    {{-- Título y Activo --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Título <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="title"
                value="{{ old('title', $announcement->title ?? '') }}"
                required
                class="w-full border border-gray-300 rounded p-2
                       focus:outline-none focus:ring-1 focus:ring-orange-200 focus:border-orange-500
                       @error('title') border-red-500 @enderror"
                placeholder="Ingresa el título"
            />
            @error('title')
                <p class="mt-1 text-red-600 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center pt-2">
            <input
                type="checkbox"
                id="active"
                name="active"
                value="1"
                {{ old('active', $announcement->active ?? false) ? 'checked' : '' }}
                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
            />
            <label for="active" class="ml-2 text-sm font-medium text-gray-700">Activo</label>
        </div>
    </div>

    {{-- Texto del anuncio --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Texto del anuncio <span class="text-red-500">*</span></label>
        <textarea
            name="text"
            rows="3"
            required
            class="w-full border border-gray-300 rounded p-2
                   focus:outline-none focus:ring-1 focus:ring-orange-200 focus:border-orange-500
                   @error('text') border-red-500 @enderror"
            placeholder="Describe el anuncio..."
        >{{ old('text', $announcement->text ?? '') }}</textarea>
        @error('text')
            <p class="mt-1 text-red-600 text-xs">{{ $message }}</p>
        @enderror
    </div>
</div>
