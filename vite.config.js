import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/filament-overrides.css',
        'resources/js/app.js',

        // —————— Añade aquí tu theme ——————
        'resources/css/filament/admin/theme.css',
      ],
      refresh: true,
    }),
    livewire({         // ⬅️ activa el plugin
           refresh: [
            'resources/css/app.css',
             'resources/views/**/*.blade.php',
           'app/Http/Livewire/**/*.php',
           ],
         }),
  ],
});
