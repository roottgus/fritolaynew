{{-- resources/views/admin/orders/_fields.blade.php --}}
<div class="mb-4">
  <label class="block font-medium">User ID</label>
  <input
    name="user_id"
    type="number"
    value="{{ old('user_id', $order->user_id ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Total</label>
  <input
    name="total"
    type="text"
    value="{{ old('total', $order->total ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Estado</label>
  <input
    name="status"
    type="text"
    value="{{ old('status', $order->status ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Origen</label>
  <input
    name="origin"
    type="text"
    value="{{ old('origin', $order->origin ?? '') }}"
    class="w-full border p-2 rounded"
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Items (JSON)</label>
  <textarea
    name="items"
    class="w-full border p-2 rounded"
    rows="4"
    required
  >{{ old('items', $order->items ?? '') }}</textarea>
</div>