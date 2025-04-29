{{-- resources/views/partials/offers.blade.php --}}
@php
  use Illuminate\Support\Str;
  use Illuminate\Support\Facades\Storage;
@endphp

<div class="mb-10">
  <h2 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-orange-500 pl-3">
    Ofertas Especiales
  </h2>
  <div class="flex justify-center gap-8 overflow-x-auto">
    @foreach ($offers as $offer)
      @php
        // Raw puede ser URL absoluta o path en storage
        $raw = data_get($offer, 'image');
        if (Str::startsWith($raw, ['http://', 'https://'])) {
            $imgUrl = $raw;
        } else {
            $imgUrl = Storage::disk('public')->url(ltrim($raw, '/'));
        }
        $alt   = data_get($offer, 'alt', '');
        $promo = data_get($offer, 'promotion_message', 'Promoción Especial');
      @endphp

      <div class="min-w-[200px] sm:min-w-[300px] rounded shadow group relative overflow-hidden">
        <img
          src="{{ $imgUrl }}"
          alt="{{ $alt }}"
          class="w-full h-40 object-cover rounded transition duration-300 group-hover:opacity-75 relative z-10"
        >
        <div
          class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 relative z-20"
        >
          <span
            class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition duration-300"
          >
            {{ $promo }}
          </span>
        </div>
      </div>
    @endforeach
  </div>
</div>
