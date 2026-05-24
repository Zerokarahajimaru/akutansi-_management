import './bootstrap';
import Swal from 'sweetalert2';

// Custom SweetAlert2 Configuration
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    },
    customClass: {
        popup: 'rounded-2xl border border-slate-100 shadow-xl',
        title: 'text-sm font-bold text-slate-800',
        timerProgressBar: 'bg-indigo-600',
    }
});

window.Swal = Swal;
window.Toast = Toast;

// Input Validation for Phone Numbers
document.addEventListener('input', (e) => {
    if (e.target.dataset.type === 'phone' || e.target.name.toLowerCase().includes('notelp')) {
        let value = e.target.value.replace(/[^0-9\-\+\s]/g, '');
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
        e.target.value = value;
    }
});