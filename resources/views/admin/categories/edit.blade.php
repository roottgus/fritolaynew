@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-gray-50 min-h-screen space-y-6">
  {{-- Header --}}
  <div class="bg-white border-l-4 border-blue-600 p-6 rounded-lg shadow">
    <h1 class="text-2xl font-semibold text-gray-800"><i class="fas fa-edit text-blue-600"></i> Editar Categoría</h1>
    <p class="text-gray-600 mt-1">Modifica el nombre de la categoría.</p>
  </div>

  {{-- Form --}}
  <div class="bg-white p-6 rounded-lg shadow">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre<span class="text-red-500">*</span></label>
        <input id="name" name="name" type="text" required value="{{ old('name', $category->name) }}"
               class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" />
        @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="flex justify-end pt-4 border-t border-gray-200">
        <a href="{{ route('admin.categories.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancelar</a>
        <button type="submit"
                class="ml-3 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          Actualizar
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
