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
            this.$nextTick(() => this.updatePosition());
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
        const menuRect = menu.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        const scrollX = window.scrollX;
        const scrollY = window.scrollY;
        const offset = 6;
        const padding = 8;

        let top = buttonRect.bottom + offset + scrollY;
        let left = buttonRect.right - menuRect.width + scrollX;

        if (left < padding + scrollX) {
            left = padding + scrollX;
        }
        if (left + menuRect.width > scrollX + viewportWidth - padding) {
            left = Math.max(padding + scrollX, scrollX + viewportWidth - menuRect.width - padding);
        }
        if (top + menuRect.height > scrollY + viewportHeight - padding) {
            top = buttonRect.top + scrollY - menuRect.height - offset;
        }
        if (top < padding + scrollY) {
            top = padding + scrollY;
        }

        this.style = `position: absolute; top: ${Math.round(top)}px; left: ${Math.round(left)}px;`;
    },
    init() {
        const handleResize = () => {
            if (this.open) {
                this.updatePosition();
            }
        };

        window.addEventListener('resize', handleResize);

        this.$watch('open', (value) => {
            if (value) {
                this.$nextTick(() => this.updatePosition());
            }
        });
    },
}));

Alpine.start();
AOS.init();

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
        event.preventDefault();
        const targetId = anchor.getAttribute('href')?.substring(1);
        const targetElement = targetId ? document.getElementById(targetId) : null;

        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
