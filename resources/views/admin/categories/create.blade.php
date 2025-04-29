{{-- resources/views/admin/categories/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-gray-50 min-h-screen space-y-6">
  {{-- Header --}}
  <div class="bg-white border-l-4 border-green-600 p-6 rounded-lg shadow">
    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
      <i class="fas fa-plus-circle text-green-600"></i> Nueva Categoría
    </h1>
    <p class="text-gray-600 mt-1">Escribe el nombre y asigna una imagen a la nueva categoría.</p>
  </div>

  {{-- Formulario --}}
  <div class="bg-white p-6 rounded-lg shadow">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      {{-- Nombre --}}
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
          Nombre<span class="text-red-500">*</span>
        </label>
        <input id="name" name="name" type="text" required value="{{ old('name') }}"
               class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2
                      focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
        @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Imagen --}}
      <div>
        <label for="image" class="block text-sm font-medium text-gray-700">
          Imagen de la categoría<span class="text-red-500">*</span>
        </label>
        <input id="image" name="image" type="file" accept="image/*" required
               class="mt-1 block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4 file:border-0
                      file:rounded-md file:text-sm file:font-semibold
                      file:bg-green-100 file:text-green-700 hover:file:bg-green-200 @error('image') border-red-500 @enderror">
        @error('image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Botones --}}
      <div class="flex justify-end pt-4 border-t border-gray-200">
        <a href="{{ route('admin.categories.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
          Cancelar
        </a>
        <button type="submit"
                class="ml-3 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
          Guardar Categoría
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
