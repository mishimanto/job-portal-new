import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();


Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});