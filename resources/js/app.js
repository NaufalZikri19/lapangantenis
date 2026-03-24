import './bootstrap';
import Swal from 'sweetalert2';
import { createIcons, icons } from 'lucide';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.Swal = Swal;
createIcons({ icons });
Alpine.start();
