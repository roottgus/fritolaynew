@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow overflow-hidden">
  <div class="bg-gradient-to-r from-yellow-400 to-red-600 p-5">
    <h1 class="text-2xl font-semibold text-white">✏️ Editar Anuncio</h1>
  </div>
  <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" class="p-6 space-y-6">
    @csrf
    @method('PUT')
    @include('admin.announcements._fields', ['announcement' => $announcement])
    <div class="text-right">
      <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
      <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded hover:bg-red-700">Guardar Cambios</button>
    </div>
  </form>
</div>
@endsection
