{{-- resources/views/errors/privacy.blade.php --}}
@extends('layouts.app-user')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 p-4">
  <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-2xl shadow-2xl max-w-md w-full text-center p-10">
    <div class="mb-6">
      <i class="fas fa-shield-alt text-6xl text-blue-600"></i>
    </div>
    <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Acceso Restringido</h1>
    <p class="text-lg text-gray-600 mb-8">Lo sentimos, esta sección es solo para administradores.</p>
    <a href="{{ url('/') }}"
       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition-all duration-200">
      <i class="fas fa-home mr-2"></i>
      Volver al inicio
    </a>
  </div>
</div>
@endsection
