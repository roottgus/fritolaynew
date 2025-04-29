{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('content')
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<div x-data class="p-6 bg-gray-50 min-h-screen">
    {{-- Header y Nuevo Usuario --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-users text-2xl text-green-600"></i>
            Gestión de Usuarios
        </h1>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-1 px-4 py-2 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 transition">
            <i class="fas fa-user-plus"></i>
            Nuevo Usuario
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de usuarios --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full table-auto">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Identif.</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Establec.</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dirección</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Temp Pass</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->codigo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($user->name) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->identificacion }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->establecimiento }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->telefono }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->direccion }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ ucfirst($user->role) }}</td>

                    {{-- Mostrar contraseña temporal o estado --}}
                    <td class="px-6 py-4 text-sm">
                        @if($user->password_temporal)
                            <span class="px-2 inline-flex items-center text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ $user->password_temporal }}
                            </span>
                        @else
                            <span class="px-2 inline-flex items-center text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Cambiada
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-center space-x-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button
                            @click.prevent="Swal.fire({
                                title: '¿Eliminar usuario #{{ $user->id }}?',
                                text: 'Esta acción es irreversible.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true,
                                customClass: {
                                    confirmButton: 'bg-red-600 text-white px-4 py-1 rounded-md hover:bg-red-700',
                                    cancelButton: 'bg-gray-200 text-gray-700 px-4 py-1 rounded-md hover:bg-gray-300'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $refs['form{{ $user->id }}'].submit();
                                }
                            })"
                            class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                        <form x-ref="form{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
