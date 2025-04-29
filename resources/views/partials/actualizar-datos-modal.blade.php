{{-- resources/views/partials/actualizar-datos-modal.blade.php --}}
<div
  x-show="openUpdate"
  x-cloak
  class="fixed inset-0 z-50 flex items-center justify-center overflow-auto"
>
  <!-- Fondo semitransparente -->
  <div class="fixed inset-0 bg-black/75 z-40" @click="openUpdate = false"></div>

  <!-- Contenedor del modal -->
  <div class="relative bg-white rounded-lg shadow-xl overflow-hidden w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2 xl:w-1/3 z-50 max-h-[90vh]">
    <!-- Encabezado del modal -->
    <div class="flex items-center justify-between bg-gradient-to-r from-yellow-400 to-orange-600 p-4">
      <div class="flex items-center gap-3">
        <img src="{{ asset('img/dyj.png') }}" alt="FritoLay" class="h-8 w-auto">
        <h3 class="text-lg font-bold text-white">Actualizar mis datos</h3>
      </div>
      <button @click="openUpdate = false" class="text-white text-2xl leading-none hover:opacity-80">&times;</button>
    </div>

    <!-- Contenido -->
    <div class="p-6">
      <!-- Mensaje de bienvenida -->
      <p class="mb-4 text-gray-600">
        Bienvenido al sistema de actualización de datos de FritoLay. Aquí podrás modificar tu <strong>correo electrónico</strong> y tu <strong>teléfono</strong>. Para cambiar cualquier otro dato, por favor contacta a nuestro equipo de soporte.
      </p>

      <form method="POST" action="{{ route('mi-cuenta.actualizar') }}">
        @csrf
        @php $user = auth()->user(); @endphp

        <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
          <table class="min-w-full table-auto">
            <tbody class="divide-y divide-gray-200">
              <!-- Código -->
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 flex items-center gap-2">
                  <i class="fas fa-barcode text-orange-500"></i>
                  <span class="font-semibold text-sm text-gray-700 uppercase">Código</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $user->codigo }}</td>
              </tr>

              <!-- Nombre completo -->
              <tr class="bg-gray-50 hover:bg-gray-100">
                <td class="px-4 py-3 flex items-center gap-2">
                  <i class="fas fa-user text-blue-500"></i>
                  <span class="font-semibold text-sm text-gray-700 uppercase">Nombre completo</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $user->name }}</td>
              </tr>

              <!-- Correo electrónico (editable) -->
              <tr class="bg-green-50 hover:bg-green-100">
                <td class="px-4 py-3 flex items-center gap-2">
                  <i class="fas fa-envelope text-red-500"></i>
                  <label for="email" class="font-semibold text-sm text-gray-700 uppercase">Correo electrónico</label>
                </td>
                <td class="px-4 py-3">
                  <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                         class="w-full rounded-md border-gray-300 shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500" />
                </td>
              </tr>

              <!-- Identificación -->
              <tr class="bg-gray-50 hover:bg-gray-100">
                <td class="px-4 py-3 flex items-center gap-2">
                  <i class="fas fa-id-card text-green-500"></i>
                  <span class="font-semibold text-sm text-gray-700 uppercase">Identificación</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $user->identificacion }}</td>
              </tr>

              <!-- Establecimiento -->
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 flex items-center gap-2">
                  <i class="fas fa-building text-purple-500"></i>
                  <span class="font-semibold text-sm text-gray-700 uppercase">Establecimiento</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $user->establecimiento }}</td>
              </tr>

              <!-- Teléfono (editable) -->
              <tr class="bg-green-50 hover:bg-green-100">
                <td class="px-4 py-3 flex items-center gap-2">
                  <i class="fas fa-phone text-teal-500"></i>
                  <label for="telefono" class="font-semibold text-sm text-gray-700 uppercase">Teléfono</label>
                </td>
                <td class="px-4 py-3">
                  <input id="telefono" type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}" required
                         class="w-full rounded-md border-gray-300 shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Botones de acción -->
        <div class="mt-6 flex justify-end space-x-2">
          <button type="button" @click="openUpdate = false"
                  class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancelar</button>
          <button type="submit"
                  class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>