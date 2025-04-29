{{-- resources/views/admin/offers/_fields.blade.php --}}

<div class="mb-4">
  <label class="block font-medium">Imagen (archivo)</label>
  <input
    name="image"
    type="file"
    accept="image/*"
    class="w-full border p-2 rounded"
    {{ isset($offer) ? '' : 'required' }}
  />
  @if(isset($offer) && $offer->image)
    <div class="mt-2">
      <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->alt }}" class="h-20">
    </div>
  @endif
</div>
<div class="mb-4">
  <label class="block font-medium">Texto alternativo (alt)</label>
  <input
    name="alt"
    type="text"
    value="{{ old('alt', $offer->alt ?? '') }}"
    class="w-full border p-2 rounded"
    required
  />
</div>
<div class="mb-4">
  <label class="block font-medium">Mensaje de Promoción</label>
  <textarea
    name="promotion_message"
    class="w-full border p-2 rounded"
    rows="4"
    required
  >{{ old('promotion_message', $offer->promotion_message ?? '') }}</textarea>
</div>
<div class="mb-4 flex items-center">
  <label class="block font-medium mr-4">Activo</label>
  <input
    name="active"
    type="checkbox"
    value="1"
    {{ old('active', $offer->active ?? false) ? 'checked' : '' }}
    class="h-4 w-4"
  />
</div>
