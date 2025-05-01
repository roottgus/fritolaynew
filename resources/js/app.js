// resources/js/app.js

// --- 1) Hot-reload de Livewire SOLO en DEV ---
if (import.meta.env.DEV) {
    import('virtual:livewire-hot-reload')
      .then(({ livewireHotReload }) => {
        if (typeof livewireHotReload === 'function') {
          livewireHotReload()
        }
      })
      .catch(() => {
        // en caso de fallo, simplemente ignoramos
      })
  }
  
  // --- 2) Resto de tus imports ---
  import Alpine from 'alpinejs'
  window.Alpine = Alpine
  Alpine.start()
  
  import './bootstrap'
  import './chart.js'
  import '../css/app.css'
  import '../css/filament-overrides.css'
  