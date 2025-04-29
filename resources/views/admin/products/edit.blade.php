{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-gray-50 min-h-screen space-y-8">
  {{-- Header --}}
  <div class="bg-white border-l-4 border-blue-600 p-6 rounded-lg shadow">
    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
      <i class="fas fa-edit text-blue-600"></i>
      Editar Producto #{{ $product->id }}
    </h1>
    <p class="text-gray-600 mt-1">Actualiza los datos del producto.</p>
  </div>

  {{-- Formulario --}}
  <div class="bg-white p-6 rounded-lg shadow">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nombre --}}
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nombre<span class="text-red-500">*</span></label>
          <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required
                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
          @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Código --}}
        <div>
          <label for="code" class="block text-sm font-medium text-gray-700">Código<span class="text-red-500">*</span></label>
          <input id="code" name="code" type="text" value="{{ old('code', $product->code) }}" required
                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror">
          @error('code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Precio --}}
        <div>
          <label for="price" class="block text-sm font-medium text-gray-700">Precio (COP)<span class="text-red-500">*</span></label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
            <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required
                   class="pl-7 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
          </div>
          @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Categoría --}}
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Categoría<span class="text-red-500">*</span></label>
          <select id="category" name="category" required
                  class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror">
            <option value="">-- Selecciona Categoría --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>
                {{ $cat }}
              </option>
            @endforeach
          </select>
          @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Imagen actual y nueva --}}
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
          @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="Imagen producto" class="w-32 h-32 object-cover rounded mb-3">
          @endif
          <input id="image" name="image" type="file" accept="image/*"
                 class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-md
                        file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700
                        hover:file:bg-blue-200 @error('image') border-red-500 @enderror">
          @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Disponible --}}
        <div class="flex items-center space-x-2">
          <input id="available" name="available" type="checkbox" value="1" {{ old('available', $product->available) ? 'checked' : '' }}
                 class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
          <label for="available" class="text-sm font-medium text-gray-700">Disponible</label>
        </div>

        {{-- Cantidad Mínima --}}
        <div>
          <label for="minQuantity" class="block text-sm font-medium text-gray-700">Cantidad Mínima</label>
          <input id="minQuantity" name="minQuantity" type="number" value="{{ old('minQuantity', $product->minQuantity) }}"
                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('minQuantity') border-red-500 @enderror">
          @error('minQuantity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Botones --}}
      <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.products.index') }}" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
          Cancelar
        </a>
        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
          <i class="fas fa-save mr-2"></i> Guardar Cambios
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
