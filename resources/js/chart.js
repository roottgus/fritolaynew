import { Chart, registerables } from 'chart.js';

// Registrar todos los componentes necesarios
Chart.register(...registerables);

// Exponer Chart globalmente para scripts inline
document.addEventListener('DOMContentLoaded', () => {
    window.Chart = Chart;
});
