@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-semibold">📢 Gestión de Anuncios</h1>
    <a href="{{ route('admin.announcements.create') }}"
       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
      + Nuevo Anuncio
    </a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icono</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Texto</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Activo</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($announcements as $announcement)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">{{ $announcement->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap"><i class="{{ $announcement->icon }} text-xl text-gray-700"></i></td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $announcement->title }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ \Illuminate\Support\Str::limit($announcement->text, 50) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
              @if($announcement->active)
                <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Sí</span>
              @else
                <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">No</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
              <a href="{{ route('admin.announcements.edit', $announcement) }}"
                 class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline"
                    onsubmit="return confirm('¿Eliminar este anuncio?');">
                @csrf @method('DELETE')
                <button type="submit"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
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
    {{ $announcements->links() }}
  </div>
</div>
@endsection
