{{-- resources/views/admin/offers/index.blade.php --}}
@extends('layouts.admin')

@section('content')
@php use Illuminate\Support\Str; @endphp

<div class="container mx-auto px-4">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Ofertas</h1>
    <a href="{{ route('admin.offers.create') }}"
       class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-base">
      Nueva Oferta
    </a>
  </div>

  <div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-base">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left font-semibold text-gray-700">Imagen</th>
          <th class="px-6 py-3 text-left font-semibold text-gray-700">Mensaje</th>
          <th class="px-6 py-3 text-left font-semibold text-gray-700">Activo</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach($offers as $offer)
        <tr>
          <td class="px-6 py-4">
            <img src="{{ asset('storage/' . $offer->image) }}"
                 alt="{{ $offer->alt }}"
                 class="h-12 w-12 object-cover rounded-lg"/>
          </td>
          <td class="px-6 py-4">{{ Str::limit($offer->promotion_message, 100) }}</td>
          <td class="px-6 py-4">
            @if($offer->active)
              <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Sí</span>
            @else
              <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">No</span>
            @endif
          </td>
          <td class="px-6 py-4 text-right space-x-2">
            <a href="{{ route('admin.offers.edit', $offer) }}"
               class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
              Editar
            </a>
            <form action="{{ route('admin.offers.destroy', $offer) }}"
                  method="POST"
                  class="inline">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm"
                      onclick="return confirm('¿Eliminar esta oferta?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $offers->links() }}
  </div>
</div>
@endsection
