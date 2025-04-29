@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
  {{-- Header --}}
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">📂 Gestión de Categorías</h1>
    <a href="{{ route('admin.categories.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
      <i class="fas fa-plus"></i> Nueva Categoría
    </a>
  </div>

  {{-- Success Message --}}
  @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  {{-- Table --}}
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
          <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($categories as $cat)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-sm text-gray-700">{{ $cat->id }}</td>
            <td class="px-6 py-4 text-sm text-gray-700">{{ $cat->name }}</td>
            <td class="px-6 py-4 text-center space-x-2">
              <a href="{{ route('admin.categories.edit', $cat) }}"
                 class="px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition">
                <i class="fas fa-edit"></i> Editar
              </a>
              <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Eliminar la categoría «{{ $cat->name }}»?');"
                        class="px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 transition">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="mt-6">
    {{ $categories->links() }}
  </div>
</div>
@endsection
