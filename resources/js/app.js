import './bootstrap';

import Alpine from 'alpinejs';

import Swal from 'sweetalert2';

// Importar módulos de utilidades
import './alert-utils.js';
import './cloudinary-utils.js';

window.Alpine = Alpine;

Alpine.start();

window.Swal = Swal;
