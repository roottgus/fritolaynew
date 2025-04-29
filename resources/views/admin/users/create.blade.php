{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">
    {{-- Encabezado --}}
    <div class="bg-gradient-to-r from-green-600 to-green-800 p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-white">👥 Crear Nuevo Usuario</h1>
        <p class="mt-1 text-green-100">Se ha generado un código y una contraseña temporal automáticamente.</p>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Código generado --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código de Usuario</label>
                    <input type="text" value="{{ $codigo }}" disabled
                           class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2" />
                    <input type="hidden" name="codigo" value="{{ $codigo }}" />
                </div>

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" />
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" />
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Identificación --}}
                <div>
                    <label for="identificacion" class="block text-sm font-medium text-gray-700 mb-1">Identificación <span class="text-red-500">*</span></label>
                    <input type="text" id="identificacion" name="identificacion" value="{{ old('identificacion') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" />
                    @error('identificacion') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Establecimiento --}}
                <div>
                    <label for="establecimiento" class="block text-sm font-medium text-gray-700 mb-1">Establecimiento <span class="text-red-500">*</span></label>
                    <input type="text" id="establecimiento" name="establecimiento" value="{{ old('establecimiento') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" />
                    @error('establecimiento') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" />
                    @error('telefono') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Dirección --}}
                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección <span class="text-red-500">*</span></label>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" />
                    @error('direccion') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Rol --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rol <span class="text-red-500">*</span></label>
                    <select id="role" name="role" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                    @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Contraseña temporal --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña Temporal</label>
                    <input type="text" value="{{ $tempPassword }}" disabled
                           class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2" />
                    <input type="hidden" name="password_temporal" value="{{ $tempPassword }}" />
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
