@extends('layouts.admin')

@push('scripts')
  <!-- Alpine.js: necesario para x-data en el partial de iconos -->
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow overflow-hidden">
  <div class="bg-gradient-to-r from-yellow-400 to-red-600 p-5">
    <h1 class="text-2xl font-semibold text-white">➕ Nuevo Anuncio</h1>
  </div>
  <form action="{{ route('admin.announcements.store') }}" method="POST" class="p-6 space-y-6">
    @csrf

    {{-- Aquí incluimos el partial de campos, pasando null para $announcement --}}
    @include('admin.announcements._fields', ['announcement' => null])

    <div class="text-right">
      <a href="{{ route('admin.announcements.index') }}"
         class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
        Cancelar
      </a>
      <button type="submit"
              class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Crear Anuncio
      </button>
    </div>
  </form>
</div>
@endsection
