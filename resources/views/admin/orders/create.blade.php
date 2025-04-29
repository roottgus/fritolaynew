{{-- resources/views/admin/orders/create.blade.php --}}
@extends('layouts.admin')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Nuevo Pedido</h1>

  <form action="{{ route('admin.orders.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf

    @include('admin.orders._fields', ['order' => null])

    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Crear</button>
  </form>
@endsection