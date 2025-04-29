@extends('layouts.admin')

@section('content')
<div class="p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">📦 Gestión de Productos</h1>
    <div class="space-x-2">
      <a href="{{ route('admin.products.create') }}"
         class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        <i class="fas fa-plus mr-1"></i> Nuevo Producto
      </a>
      {{-- Botón de Carga Masiva eliminado --}}
    </div>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">ID</th>
          <th class="px-4 py-2">Imagen</th>
          <th class="px-4 py-2">Nombre</th>
          <th class="px-4 py-2">Código</th>
          <th class="px-4 py-2">Precio</th>
          <th class="px-4 py-2">Categoría</th>
          <th class="px-4 py-2">Disponible</th>
          <th class="px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $p)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ $p->id }}</td>
            <td class="px-4 py-2">
              @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" class="w-10 h-10 object-cover rounded" alt="">
              @else
                <span class="text-gray-400">–</span>
              @endif
            </td>
            <td class="px-4 py-2">{{ $p->name }}</td>
            <td class="px-4 py-2">{{ $p->code }}</td>
            <td class="px-4 py-2">COP {{ number_format($p->price,0,',','.') }}</td>
            <td class="px-4 py-2">{{ $p->category }}</td>
            <td class="px-4 py-2">
              @if($p->available)
                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Sí</span>
              @else
                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">No</span>
              @endif
            </td>
            <td class="px-4 py-2 whitespace-nowrap">
              <a href="{{ route('admin.products.edit', $p) }}" class="px-2 py-1 text-blue-600 hover:underline">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Eliminar este producto?');">
                @csrf @method('DELETE')
                <button type="submit" class="px-2 py-1 text-red-600 hover:underline">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $products->links() }}
  </div>
</div>
@endsection
