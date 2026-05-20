import './bootstrap';

import Alpine from 'alpinejs';

import AOS from 'aos';
import 'aos/dist/aos.css';

import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';

import Swal from 'sweetalert2';

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

import './reunion-header';

window.Alpine = Alpine;
window.AOS = AOS;
window.GLightbox = GLightbox;
window.Swal = Swal;
window.Swiper = Swiper;

function initLightboxes() {
    if (document.querySelector('.glightbox-gallery')) {
        GLightbox({
            selector: '.glightbox-gallery',
            touchNavigation: true,
            loop: true,
        });
    }

    if (document.querySelector('.glightbox-video')) {
        GLightbox({
            selector: '.glightbox-video',
            touchNavigation: true,
            loop: false,
        });
    }
}

function initClassSwiper() {
    const classSwiperEl = document.querySelector('.class-swiper');

    if (!classSwiperEl) {
        return;
    }

    new Swiper(classSwiperEl, {
        effect: 'coverflow',
        grabCursor: false,
        centeredSlides: true,
        rewind: true,
        speed: 650,
        slidesPerView: 1.15,
        spaceBetween: 18,

        preventClicks: false,
        preventClicksPropagation: false,
        touchStartPreventDefault: false,

        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 90,
            modifier: 1,
            slideShadows: false,
        },

        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },

        navigation: {
            nextEl: '.class-swiper-next',
            prevEl: '.class-swiper-prev',
        },

        pagination: {
            el: '.class-swiper-pagination',
            clickable: true,
        },

        breakpoints: {
            640: {
                slidesPerView: 2.15,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 22,
            },
            1280: {
                slidesPerView: 3,
                spaceBetween: 24,
            },
        },
    });

    bindClassGallery();
}

function bindClassGallery() {
    document.addEventListener('click', function (event) {
        const trigger = event.target.closest('[data-class-gallery-trigger]');
        const imageLink = event.target.closest('.class-card-image.js-class-gallery');

        if (!trigger && !imageLink) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const card = event.target.closest('.class-card-slider');

        if (!card) {
            return;
        }

        openClassGallery(card);
    });
}

function openClassGallery(card) {
    const links = Array.from(card.querySelectorAll('.js-class-gallery'));

    const items = links
        .map((link) => {
            const href = link.getAttribute('href');

            if (!href || href === '#') {
                return null;
            }

            return {
                href,
                type: 'image',
                title: link.getAttribute('data-title') || '',
            };
        })
        .filter(Boolean);

    if (!items.length) {
        return;
    }

    const lightbox = GLightbox({
        elements: items,
        touchNavigation: true,
        loop: true,
        closeOnOutsideClick: true,
    });

    lightbox.open();
}

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 700,
        once: true,
        offset: 30,
    });

    window.setTimeout(() => {
        initLightboxes();
        initClassSwiper();
    }, 0);
});