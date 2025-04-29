import { livewireHotReload } from 'virtual:livewire-hot-reload';
livewireHotReload();

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './bootstrap';
import './chart.js';
import '../css/app.css';
import '../css/filament-overrides.css';
