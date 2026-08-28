import '../css/dashboard.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../css/landing.css';

import * as bootstrap from 'bootstrap';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.min.css';

window.bootstrap = bootstrap;
window.Cropper = Cropper;

/* Reveal-on-scroll for .reveal elements (respects reduced-motion) */
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const els = document.querySelectorAll('.reveal');

    if (!('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('show'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    els.forEach((el) => observer.observe(el));
});
