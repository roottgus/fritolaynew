// tailwind.config.js
/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
const preset = require('./vendor/filament/support/tailwind.config.preset')

module.exports = {
  presets: [preset],
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/vue/**/*.vue',
    './vendor/filament/**/*.blade.php',
    './vendor/filament/**/*.js',
    './resources/views/livewire/**/*.blade.php',
    './app/Http/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        gray:   colors.gray,
        yellow: colors.yellow,
        amber:  colors.amber,
        green:  colors.green,
        emerald: colors.emerald,
        red:    colors.red,
      },
    },
  },
  plugins: [],
}
