import './bootstrap';
import Swal from 'sweetalert2';
import { createIcons, icons } from 'lucide';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Swal = Swal;
window.Chart = Chart;
window.lucide = {
    createIcons: (opts = {}) => createIcons({ icons, ...opts }),
    icons
};
window.lucide.createIcons();
Alpine.start();
