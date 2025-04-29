{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-gray-50 min-h-screen">
    {{-- Encabezado --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-lg shadow-md mb-6">
        <h1 class="text-3xl font-bold flex items-center gap-2">
            <i class="fas fa-user-edit text-2xl"></i>
            Editar Usuario
        </h1>
        <p class="mt-1 text-blue-100">Actualiza los datos del usuario y asigna una nueva contraseña temporal si lo deseas.</p>
    </div>

    {{-- Formulario de edición --}}
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Código de Usuario -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Código de Usuario</label>
                <input type="text" value="{{ $user->codigo }}" disabled
                       class="mt-1 w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2 text-gray-700" />
            </div>

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input id="name" name="name" type="text" required
                       value="{{ old('name', $user->name) }}"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required
                       value="{{ old('email', $user->email) }}"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Rol -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                <select id="role" name="role" required
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Identificación -->
            <div>
                <label for="identificacion" class="block text-sm font-medium text-gray-700">Identificación</label>
                <input id="identificacion" name="identificacion" type="text" required
                       value="{{ old('identificacion', $user->identificacion) }}"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('identificacion') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Establecimiento -->
            <div>
                <label for="establecimiento" class="block text-sm font-medium text-gray-700">Establecimiento</label>
                <input id="establecimiento" name="establecimiento" type="text" required
                       value="{{ old('establecimiento', $user->establecimiento) }}"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('establecimiento') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input id="telefono" name="telefono" type="text" required
                       value="{{ old('telefono', $user->telefono) }}"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('telefono') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Dirección -->
            <div class="md:col-span-2">
                <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                <input id="direccion" name="direccion" type="text" required
                       value="{{ old('direccion', $user->direccion) }}"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('direccion') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Contraseña Temporal -->
<div x-data="{ temp: '' }" class="md:col-span-2">
    <label for="password_temporal" class="block text-sm font-medium text-gray-700">Contraseña Temporal</label>
    <div class="mt-1 flex items-center gap-2">
        <input
            x-model="temp"
            id="password_temporal"
            name="password_temporal"
            type="text"
            placeholder="Deja vacío para no cambiar"
            class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
        />
        <button
            type="button"
            @click="temp = Math.random().toString(36).slice(-8)"
            class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition"
        >
            <i class="fas fa-key"></i>
            Generar
        </button>
    </div>
    @error('password_temporal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<!-- Botones -->
        <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
