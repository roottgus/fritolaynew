{{-- resources/views/admin/offers/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-2xl overflow-hidden">
  <div class="bg-gradient-to-r from-yellow-400 to-red-600 p-4">
    <h2 class="text-xl font-bold text-white">Editar Oferta</h2>
  </div>
  <form action="{{ route('admin.offers.update', $offer) }}"
        method="POST"
        enctype="multipart/form-data"
        class="p-4 space-y-4">
    @csrf
    @method('PUT')

    @include('admin.offers._fields', ['offer' => $offer])

    <div class="flex justify-end space-x-2 pt-2 border-t border-gray-200">
      <a href="{{ route('admin.offers.index') }}"
         class="px-3 py-1.5 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition text-sm">
        Cancelar
      </a>
      <button type="submit"
              class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition text-sm">
        Guardar
      </button>
    </div>
  </form>
</div>
@endsection
