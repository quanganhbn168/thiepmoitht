import './bootstrap';

// Alpine is provided by Livewire 3, but for public pages without Livewire, we need to initialize it manually
// or ensure Livewire scripts are present. Since we want these pages to be lightweight:
// Alpine is provided by Livewire 3 (Dashboard) or CDN (Public Pages)
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';
window.AOS = AOS;

import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';
window.GLightbox = GLightbox;

import Swal from 'sweetalert2';
window.Swal = Swal;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // ---- AOS Init ----
    AOS.init({ duration: 700, once: true, offset: 30 });

    // ---- GLightbox ----
    if (document.querySelector('.glightbox-gallery')) {
        GLightbox({ selector: '.glightbox-gallery', touchNavigation: true, loop: true });
    }
    if (document.querySelector('.glightbox-video')) {
        GLightbox({ selector: '.glightbox-video', touchNavigation: true, loop: false });
    }
});
