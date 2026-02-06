import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import AOS from 'aos';
import 'aos/dist/aos.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('actionDropdown', () => ({
    open: false,
    style: '',
    toggle() {
        this.open = !this.open;
        if (this.open) {
            // Use requestAnimationFrame to ensure DOM has updated
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    this.updatePosition();
                });
            });
        }
    },
    close() {
        this.open = false;
    },
    updatePosition() {
        const button = this.$refs.button;
        const menu = this.$refs.menu;
        if (!button || !menu) {
            return;
        }

        const buttonRect = button.getBoundingClientRect();
        const menuWidth = 160; // Fixed menu width (w-40 = 10rem = 160px)
        const menuHeight = menu.offsetHeight || 150; // Estimate if not available
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        const offset = 6;
        const padding = 8;

        // Use fixed positioning (relative to viewport)
        let top = buttonRect.bottom + offset;
        let left = buttonRect.right - menuWidth;

        // Keep within viewport bounds
        if (left < padding) {
            left = padding;
        }
        if (left + menuWidth > viewportWidth - padding) {
            left = Math.max(padding, viewportWidth - menuWidth - padding);
        }

        // If menu would go below viewport, show above button
        if (top + menuHeight > viewportHeight - padding) {
            top = buttonRect.top - menuHeight - offset;
        }
        if (top < padding) {
            top = padding;
        }

        this.style = `position: fixed; top: ${Math.round(top)}px; left: ${Math.round(left)}px; z-index: 9999;`;
    },
    init() {
        const handleScroll = () => {
            if (this.open) {
                this.updatePosition();
            }
        };

        const handleResize = () => {
            if (this.open) {
                this.updatePosition();
            }
        };

        window.addEventListener('resize', handleResize);
        window.addEventListener('scroll', handleScroll, true);

        this.$watch('open', (value) => {
            if (value) {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        this.updatePosition();
                    });
                });
            }
        });
    },
}));

Alpine.start();
AOS.init();

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
        const href = anchor.getAttribute('href');
        // Skip if href is just '#' or empty
        if (!href || href === '#') {
            return;
        }

        const targetId = href.substring(1);
        const targetElement = targetId ? document.getElementById(targetId) : null;

        // Only prevent default and scroll if target element exists
        if (targetElement) {
            event.preventDefault();
            targetElement.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
