

import Alpine from 'alpinejs';
import { Chart, registerables } from 'chart.js';

// Register Chart.js components
Chart.register(...registerables);

// Make Chart.js globally available
window.Chart = Chart;

window.Alpine = Alpine;

Alpine.start();
