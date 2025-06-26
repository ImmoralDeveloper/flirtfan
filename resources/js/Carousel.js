export default class Carousel {
    constructor(containerSelector, options = {}) {
        this.container = document.querySelector(containerSelector);
        this.wrapper = this.container.querySelector('.carousel-wrapper');
        this.btnPrev = this.container.querySelector('[data-dir="prev"]');
        this.btnNext = this.container.querySelector('[data-dir="next"]');
        this.scrollAmount = options.scrollAmount || 100;
        this.dragSpeed = options.dragSpeed || 2;
        this.touchSpeed = options.touchSpeed || 1;

        this._bindEvents();
        this._enableDrag();
        this._updateButtons(); // Inicializa el estado de los botones
    }

    _bindEvents() {
        if (this.btnPrev) {
            this.btnPrev.addEventListener('click', () => {
                this.wrapper.scrollBy({ left: -this.scrollAmount, behavior: 'smooth' });
            });
        }

        if (this.btnNext) {
            this.btnNext.addEventListener('click', () => {
                this.wrapper.scrollBy({ left: this.scrollAmount, behavior: 'smooth' });
            });
        }

        this.wrapper.addEventListener('scroll', () => this._updateButtons());
        window.addEventListener('resize', () => this._updateButtons());
    }

    _updateButtons() {
        const scrollLeft = this.wrapper.scrollLeft;
        const maxScroll = this.wrapper.scrollWidth - this.wrapper.clientWidth;

        if (this.btnPrev) {
            this.btnPrev.disabled = scrollLeft <= 1;
            this.btnPrev.classList.toggle('disabled', scrollLeft <= 1);
        }

        if (this.btnNext) {
            this.btnNext.disabled = scrollLeft >= maxScroll - 1;
            this.btnNext.classList.toggle('disabled', scrollLeft >= maxScroll - 1);
        }
    }

    _enableDrag() {
        let isDown = false;
        let startX;
        let scrollLeft;

        const startDrag = (x) => {
            isDown = true;
            this.wrapper.classList.add('dragging');
            startX = x - this.wrapper.offsetLeft;
            scrollLeft = this.wrapper.scrollLeft;
        };

        const moveDrag = (x, speed) => {
            if (!isDown) return;
            const delta = (x - startX) * speed;
            const newScroll = scrollLeft - delta;

            const maxScroll = this.wrapper.scrollWidth - this.wrapper.clientWidth;

            // Limitar el scroll al rango válido
            this.wrapper.scrollLeft = Math.max(0, Math.min(newScroll, maxScroll));
        };

        const stopDrag = () => {
            isDown = false;
            this.wrapper.classList.remove('dragging');
        };

        // Mouse
        this.wrapper.addEventListener('mousedown', (e) => startDrag(e.pageX));
        this.wrapper.addEventListener('mouseleave', stopDrag);
        this.wrapper.addEventListener('mouseup', stopDrag);
        this.wrapper.addEventListener('mousemove', (e) => moveDrag(e.pageX, this.dragSpeed));

        // Touch
        this.wrapper.addEventListener('touchstart', (e) => startDrag(e.touches[0].pageX));
        this.wrapper.addEventListener('touchend', stopDrag);
        this.wrapper.addEventListener('touchmove', (e) => moveDrag(e.touches[0].pageX, this.touchSpeed));
    }
}
