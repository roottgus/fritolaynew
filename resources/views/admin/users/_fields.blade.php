{{-- resources/views/admin/users/_fields.blade.php --}}
<div class="mb-4">
  <label class="block font-medium">Código</label>
  <input
    name="codigo"
    type="text"
    value="{{ old('codigo', $user->codigo ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Nombre</label>
  <input
    name="name"
    type="text"
    value="{{ old('name', $user->name ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Email</label>
  <input
    name="email"
    type="email"
    value="{{ old('email', $user->email ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Contraseña</label>
  <input
    name="password"
    type="password"
    class="w-full border p-2 rounded"
    {{ isset($user) ? '' : 'required' }}
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Contraseña Temporal</label>
  <input
    name="password_temporal"
    type="password"
    class="w-full border p-2 rounded"
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Rol</label>
  <input
    name="role"
    type="text"
    value="{{ old('role', $user->role ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Identificación</label>
  <input
    name="identificacion"
    type="text"
    value="{{ old('identificacion', $user->identificacion ?? '') }}"
    class="w-full border p-2 rounded"
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Establecimiento</label>
  <input
    name="establecimiento"
    type="text"
    value="{{ old('establecimiento', $user->establecimiento ?? '') }}"
    class="w-full border p-2 rounded"
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Teléfono</label>
  <input
    name="telefono"
    type="tel"
    value="{{ old('telefono', $user->telefono ?? '') }}"
    class="w-full border p-2 rounded"
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Dirección</label>
  <input
    name="direccion"
    type="text"
    value="{{ old('direccion', $user->direccion ?? '') }}"
    class="w-full border p-2 rounded"
  />
</div>
