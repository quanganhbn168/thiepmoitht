import '../css/reunion-header.css';

const MOBILE_MENU_BREAKPOINT = 760;

function initReunionHeader() {
    const header = document.getElementById('site-header');

    if (!header) {
        return;
    }

    const toggle = header.querySelector('[data-reunion-menu-toggle]');
    const menu = header.querySelector('[data-reunion-menu]');

    function updateHeaderState() {
        header.classList.toggle('is-scrolled', window.scrollY > 24);
    }

    function setMenuState(isOpen) {
        header.classList.toggle('is-menu-open', isOpen);

        if (toggle) {
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Đóng menu' : 'Mở menu');
        }
    }

    updateHeaderState();
    window.addEventListener('scroll', updateHeaderState, { passive: true });

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', () => {
        setMenuState(!header.classList.contains('is-menu-open'));
    });

    menu.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', () => setMenuState(false));
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > MOBILE_MENU_BREAKPOINT) {
            setMenuState(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuState(false);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReunionHeader, { once: true });
} else {
    initReunionHeader();
}
