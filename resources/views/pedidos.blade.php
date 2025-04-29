@extends('layouts.app-user')

@section('content')
<div x-data="pedidosData()" class="p-4 relative">
  {{-- Modal de Zoom --}}
  <div
    x-show="zoomImage !== null"
    x-cloak
    style="display: none;"
    x-transition.opacity.duration.200ms
    class="fixed inset-0 bg-gradient-to-br from-gray-800/50 to-black/70 flex items-center justify-center z-50"
    @click.self="zoomImage = null"
  >
    <div class="relative max-w-[90vw] max-h-[90vh]">
      <button
        @click="zoomImage = null"
        class="absolute top-2 right-2 text-white text-2xl font-bold z-50"
      >&times;</button>
      <img :src="zoomImage" class="max-w-full max-h-full rounded shadow-lg" />
    </div>
  </div>

  {{-- Overlay del carrito: totalmente transparente + desenfoque suave --}}
  <div
    x-show="isCartOpen"
    x-cloak
    style="display: none;"
    x-transition.opacity.duration.200ms
    class="fixed inset-0 bg-transparent backdrop-blur-[1px] z-40"
    @click.self="isCartOpen = false"
  ></div>

  <!-- Botón flotante para abrir el carrito -->
  <button
    @click.stop="isCartOpen = true"
    class="fixed bottom-8 right-8 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition z-50"
  >
    <i class="fas fa-shopping-cart text-lg"></i>
    <template x-if="totalItems > 0">
      <span class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center" x-text="totalItems"></span>
    </template>
  </button>

  <!-- Carrito lateral -->
  <div
    x-cloak
    :class="{'translate-x-0': isCartOpen, 'translate-x-full': !isCartOpen}"
    class="fixed top-0 right-0 h-screen w-80 bg-white shadow-2xl transform transition-transform duration-300 z-50"
  >
    <button
      @click="isCartOpen = false"
      class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition"
    >
      <i class="fas fa-times text-lg"></i>
    </button>
    <div class="p-4 mt-10">
      <!-- Carrito Sidebar -->
      <div class="flex flex-col h-full rounded-lg" style="max-height: calc(100vh - 4rem);">
        <div class="bg-gradient-to-r from-[#eea924] to-[#d32a1e] text-white p-4 rounded-lg">
          <div class="flex justify-center items-center">
            <i class="fas fa-shopping-cart mr-2"></i>
            <h2 class="text-2xl font-bold">Tu Pedido</h2>
          </div>
        </div>
        <div class="p-4 flex-1 overflow-y-auto bg-white">
          <template x-if="cartItems.length === 0">
            <p class="text-gray-600">No hay productos en el carrito.</p>
          </template>
          <template x-for="item in cartItems" :key="item.id">
            <div class="space-y-2 bg-gray-50 border border-gray-200 rounded p-3 flex items-center">
              <img :src="item.image" :alt="item.name" class="w-16 h-12 object-contain rounded mr-4">
              <div class="flex-1">
                <p class="text-sm font-semibold text-gray-700" x-text="item.name"></p>
                <p class="text-xs text-gray-500">
                  Cantidad: <span x-text="item.quantity"></span>
                </p>
                <p class="text-xs font-semibold text-green-600">
                  Precio: $<span x-text="parseFloat(item.price).toFixed(2)"></span>
                </p>
              </div>
              <div class="flex flex-col items-center space-y-1">
                <button @click="incrementQuantity(item.id)" class="bg-blue-600 text-white rounded p-1 hover:bg-blue-700 transition">
                  <i class="fas fa-plus text-xs"></i>
                </button>
                <button @click="decrementQuantity(item.id)" class="bg-red-600 text-white rounded p-1 hover:bg-red-700 transition">
                  <i class="fas fa-minus text-xs"></i>
                </button>
              </div>
            </div>
          </template>
        </div>
        <div class="bg-gray-50 border-t border-gray-200 p-4">
          <p class="text-base font-semibold text-gray-800 mb-1">
            Total Items: <span x-text="totalItems"></span>
          </p>
          <p class="text-base font-semibold text-gray-800">
            Total: COP<span x-text="totalPrice"></span>
          </p>
          <template x-if="cartItems.length > 0">
            <button
              @click="handleCheckout"
              class="mt-3 w-full bg-[#eea924] text-white text-sm font-semibold py-2 rounded hover:bg-[#d18b1f] transition"
            >
              Finalizar Pedido
            </button>
          </template>
        </div>
        <footer class="bg-white text-xs text-gray-500 text-center p-2 border-t border-gray-200">
          © 2025. Todos los derechos reservados.
        </footer>
      </div>
    </div>
  </div>

  <!-- Mensaje Informativo -->
  <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-800 text-sm rounded">
    En esta área puedes solicitar tus productos directamente a la empresa...
  </div>

  <!-- Categorías -->
  <div class="mb-6 bg-gray-50 p-4 rounded-lg">
    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Categorías</h2>
    <div class="flex justify-center gap-4 overflow-x-auto py-2">
      <template x-for="(cat, index) in categories" :key="index">
        <div class="flex-shrink-0">
          <div
            @click="selectCategory(index)"
            :class="{
              'flex flex-col items-center bg-white rounded-lg shadow-md p-4 transition-transform hover:scale-105 border-2 border-blue-500': selectedCategory === index,
              'flex flex-col items-center bg-white rounded-lg shadow-md p-4 transition-transform hover:scale-105 border border-transparent hover:border-blue-500': selectedCategory !== index
            }"
          >
            <img :src="cat.img" :alt="cat.name" class="w-20 h-20 object-contain mb-2">
            <span class="text-sm font-semibold text-gray-700" x-text="cat.name"></span>
          </div>
        </div>
      </template>
    </div>
  </div>

  <hr class="my-4 border-gray-300" />

  <!-- Grid de Productos -->
  <h2 class="text-lg font-bold mb-2 text-gray-700">Todos los Productos</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-6 gap-3">
    <template x-for="producto in filteredProductos" :key="producto.id">
      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-transform transform hover:scale-[1.02] p-3 flex flex-col items-center group relative border border-gray-200 text-sm">
        <!-- Imagen -->
        <img :src="producto.image" :alt="producto.name"
             class="w-20 h-20 object-contain mb-2 transition-transform duration-200 group-hover:scale-105 cursor-zoom-in"
             @click="zoomImage = producto.image">
        <!-- Nombre -->
        <h3 class="font-medium text-gray-800 text-center mb-0.5 leading-snug" x-text="producto.name"></h3>
        <!-- Código -->
        <p class="text-[11px] text-gray-500 mb-1" x-text="'Código: ' + producto.code"></p>
        <!-- Precio -->
        <p class="text-sm font-semibold text-green-600 mb-1">COP <span x-text="producto.price"></span></p>
        <!-- Cantidad mínima -->
        <template x-if="producto.minQuantity > 0">
          <div class="absolute top-1 right-1 bg-yellow-400 text-white text-[10px] font-semibold px-1 py-0.5 rounded-bl">
            Min: <span x-text="producto.minQuantity"></span>
          </div>
        </template>
        <!-- Controles -->
        <div class="w-full flex items-center justify-between mt-auto gap-1">
          <input type="number" min="1"
                 class="border border-gray-300 rounded px-1 py-0.5 w-14 text-xs text-center focus:ring-blue-400 focus:ring-1"
                 :placeholder="producto.minQuantity ? 'Min ' + producto.minQuantity : 'Cant.'"
                 :disabled="!producto.available"
                 x-model.number="quantities[producto.id]">
          <button @click="handleSelectProduct(producto.id)"
                  :disabled="!producto.available || !quantities[producto.id] || quantities[producto.id] <= 0"
                  class="bg-blue-600 text-white text-xs py-0.5 px-2 rounded hover:bg-blue-700 transition"
                  :class="{'opacity-50 cursor-not-allowed': !producto.available || !quantities[producto.id] || quantities[producto.id] <= 0}">
            Agregar
          </button>
        </div>
        <!-- Estados -->
        <template x-if="!producto.available">
          <div class="absolute top-0 left-0 bg-red-500 text-white text-[10px] px-1 py-0.5 rounded-br">
            Agotado
          </div>
        </template>
        <template x-if="isSelected(producto.id)">
          <div class="absolute top-0 right-0 bg-green-600 text-white text-[10px] px-1 py-0.5 rounded-bl">
            Seleccionado
          </div>
        </template>
      </div>
    </template>
  </div>
<!-- Separador: añade espacio extra -->
<div class="mt-12"></div>
  <!-- Ofertas: se cargan dinámicamente desde el backend -->
  @include('partials.offers')

  <!-- Modal de confirmación: integrado dentro del contenedor principal -->
  <div
    x-show="openSuccessModal"
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
    <div
      @click.away="openSuccessModal = false"
      class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative"
    >
      <!-- Logo -->
      <div class="flex justify-center mb-4">
        <img src="{{ asset('img/dyj.png') }}" alt="Logo FritoLay" class="h-12">
      </div>
      <!-- Icono de éxito -->
      <div class="flex justify-center mb-4 text-green-600">
        <i class="fas fa-check-circle text-4xl"></i>
      </div>
      <!-- Mensaje -->
      <h2 class="text-xl font-bold text-gray-800 text-center mb-2">
        ¡Pedido Enviado!
      </h2>
      <p class="text-center text-gray-600 mb-6">
        Tu pedido <span class="font-semibold">#<span x-text="successOrderId"></span></span> 
        ha sido recibido correctamente.
      </p>
      <!-- Botón de cerrar o ir a inicio -->
      <div class="flex justify-center">
      <button
  @click="openSuccessModal = false; window.location.href='{{ route('mi-cuenta') }}'"
  class="px-6 py-2 bg-[#eea924] hover:bg-[#d18b1f] text-white font-medium rounded-lg transition"
>
  Ir a Mi Cuenta
</button>

        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function pedidosData() {
    return {
      productos: @json($productos ?? []),
      offersData: @json($offers ?? []),
      zoomImage: null,
      storageUrl: "{{ asset('storage') }}",
      selectedCategory: null,
      selectedProducts: {},
      quantities: {},
      isCartOpen: false,
      openSuccessModal: false,
      successOrderId: null,
      // Ahora cargamos dinámicamente todas las categorías pasadas desde el controlador
      categories: @json($categories ?? []),

      get filteredProductos() {
        if (this.selectedCategory !== null) {
          return this.productos.filter(p =>
            p.category === this.categories[this.selectedCategory].name
          );
        }
        return this.productos;
      },

      get cartItems() {
        return Object.keys(this.selectedProducts).map(id => {
          const product = this.productos.find(p => p.id === parseInt(id));
          return { ...product, quantity: this.selectedProducts[id] };
        });
      },

      get totalItems() {
        return Object.values(this.selectedProducts).reduce((sum, q) => sum + q, 0);
      },

      get totalPrice() {
        return Object.keys(this.selectedProducts)
          .reduce((sum, id) => {
            const product = this.productos.find(p => p.id === parseInt(id));
            return sum + parseFloat(product.price) * this.selectedProducts[id];
          }, 0)
          .toFixed(2);
      },

      selectCategory(index) {
        this.selectedCategory = this.selectedCategory === index ? null : index;
      },

      handleSelectProduct(id) {
        const product = this.productos.find(p => p.id === id);
        if (!product || !product.available) return;
        const quantity = parseInt(this.quantities[id]) || 0;
        if (product.minQuantity && quantity < product.minQuantity) {
          alert(`La cantidad mínima para ${product.name} es ${product.minQuantity} unidades.`);
          return;
        }
        if (quantity > 0) {
          this.selectedProducts[id] = quantity;
          this.isCartOpen = true;
        }
      },

      incrementQuantity(id) {
        if (this.selectedProducts[id] !== undefined) {
          this.selectedProducts[id]++;
        }
      },

      decrementQuantity(id) {
        if (this.selectedProducts[id] !== undefined) {
          const newQty = this.selectedProducts[id] - 1;
          if (newQty <= 0) {
            delete this.selectedProducts[id];
          } else {
            this.selectedProducts[id] = newQty;
          }
        }
      },

      removeProduct(id) {
        delete this.selectedProducts[id];
      },

      isSelected(id) {
        return Object.prototype.hasOwnProperty.call(this.selectedProducts, id);
      },

      async handleCheckout() {
        const items = Object.keys(this.selectedProducts).map(id => {
          const product = this.productos.find(p => p.id === parseInt(id));
          return {
            product_id: product.id,
            name: product.name,
            quantity: this.selectedProducts[id],
            unit_price: product.price,
            subtotal: product.price * this.selectedProducts[id],
          };
        });

        const total = items.reduce((sum, item) => sum + item.subtotal, 0);

        try {
          const response = await fetch("{{ route('orders.store') }}", {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items, total })
          });

          if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || 'Error al enviar el pedido');
          }

          const data = await response.json();
          this.selectedProducts = {};
          this.quantities = {};
          this.isCartOpen = false;
          this.successOrderId = data.order_id;
          this.openSuccessModal = true;
        } catch (err) {
          console.error('Error en handleCheckout:', err);
          alert(err.message);
        }
      },
    };
  }
</script>

@endsection
