<section
  class="mb-6 p-4 bg-gray-200 rounded-lg shadow"
  x-data='{
    announcements: @json($announcements),
    activeIndex: 0
  }'
  x-init='if (announcements.length > 0) {
      setInterval(function() {
        activeIndex = (activeIndex + 1) % announcements.length;
      }, 3000);
    }'
  x-cloak
>
  <h2 class="text-2xl font-bold text-blue-900 mb-4">Novedades y Anuncios</h2>

  <template x-if="announcements.length > 0">
    <div class="p-4 bg-white rounded-lg shadow flex items-center gap-4 transition-all duration-700">
      <i :class="announcements[activeIndex].icon" class="text-2xl"></i>
      <div>
        <h3 class="text-xl font-semibold text-gray-800" x-text="announcements[activeIndex].title"></h3>
        <p class="text-gray-700 mt-2" x-text="announcements[activeIndex].text"></p>
      </div>
    </div>
  </template>

  <template x-if="announcements.length === 0">
    <p class="text-gray-700">No hay anuncios.</p>
  </template>
</section>