// Slider.js
export default class Slider {
    constructor(container, {
        loop = false,
        autoplay = false,
        interval = 5000,
        itemsPerView = 1,
        step = 1
    } = {}) {
        this.container = container;
        this.wrapper = container.querySelector('.slider-wrapper');
        this.slides = this.wrapper?.querySelectorAll('.slide') || [];
        this.loop = loop;
        this.autoplay = autoplay;
        this.interval = interval;
        this.itemsPerView = itemsPerView;
        this.step = step;
        this.currentIndex = 0;
        this.timer = null;

        if (!this.wrapper || this.slides.length === 0) return;

        if (container.dataset.initialized === 'true') return;
        container.dataset.initialized = 'true';

        this.setup();
        this.attachEvents();
        if (autoplay) this.startAutoplay();
    }

    setup() {
        this.updateTransform();
        this.updateButtons();
        this.wrapper.style.display = 'flex';
        this.wrapper.style.transition = 'transform 0.3s ease';
        this.wrapper.style.willChange = 'transform';

        this.slides.forEach(slide => {
            slide.style.minWidth = `${100 / this.itemsPerView}%`;
        });
    }

    updateSlideVideos() {
        // Pausa todos los videos dentro del contenedor del slider
        this.container.querySelectorAll('video').forEach(video => {
            video.pause();
            console.log('Pausando video', video);
        });

        // Reproduce el video del slide visible (si existe)
        const visibleSlide = this.slides[this.currentIndex];
        if (visibleSlide) {
            const video = visibleSlide.querySelector('video');
            if (video) {
                video.play().catch(() => {});
                console.log('Reproduciendo video', video);
            }
        }
    }

    move(dir) {
        const maxIndex = this.slides.length - this.itemsPerView;

        if (dir === 'next') {
            this.currentIndex += this.step;
            if (this.currentIndex > maxIndex) {
                this.currentIndex = this.loop ? 0 : maxIndex;
            }
        } else if (dir === 'prev') {
            this.currentIndex -= this.step;
            if (this.currentIndex < 0) {
                this.currentIndex = this.loop ? maxIndex : 0;
            }
        } else {
            const parsed = parseInt(dir, 10);
            if (!isNaN(parsed)) {
                this.currentIndex = Math.max(0, Math.min(parsed, maxIndex));
            }
        }

        this.updateTransform();
        this.updateButtons();
        this.updateSlideVideos();
    }

    updateTransform() {
        const percent = -(100 / this.itemsPerView) * this.currentIndex;
        this.wrapper.style.transform = `translateX(${percent}%)`;
    }

    updateButtons() {
        if (!this.loop) {
            const prev = this.container.querySelector('[data-dir="prev"]');
            const next = this.container.querySelector('[data-dir="next"]');
            const maxIndex = this.slides.length - this.itemsPerView;
            if (prev) prev.classList.toggle('disabled', this.currentIndex === 0);
            if (next) next.classList.toggle('disabled', this.currentIndex >= maxIndex);
        }
    }

    startAutoplay() {
        this.timer = setInterval(() => this.move('next'), this.interval);
    }

    stopAutoplay() {
        if (this.timer) clearInterval(this.timer);
    }

    attachEvents() {
        this.enableDragging();

        // Touch start listener to fix touch-init issue
        this.wrapper.addEventListener('touchstart', () => {}, { passive: true });
    }

    enableDragging() {
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let animationFrame;
        let pointerEventsDisabled = false;

        const setVideosPointerEvents = (value) => {
            this.container.querySelectorAll('video').forEach(video => {
                video.style.pointerEvents = value;
            });
        };

        const onDragStart = (x) => {
            isDragging = true;
            startX = x;
            currentX = x;
            this.wrapper.style.transition = 'none';
            pointerEventsDisabled = false;
        };

        const onDragMove = (x) => {
            if (!isDragging) return;
            currentX = x;
            const dx = currentX - startX;
            const percent = (dx / this.container.offsetWidth) * 100;
            const base = -(100 / this.itemsPerView) * this.currentIndex;
            this.wrapper.style.transform = `translateX(calc(${base}% + ${percent}%))`;
            if (!pointerEventsDisabled && Math.abs(dx) > 5) {
                setVideosPointerEvents('none');
                pointerEventsDisabled = true;
            }
        };

        const onDragEnd = () => {
            if (!isDragging) return;
            const dx = currentX - startX;
            const threshold = this.container.offsetWidth / 10;
            if (Math.abs(dx) < 5) {
                this.updateTransform();
            } else if (dx > threshold) {
                this.move('prev');
            } else if (dx < -threshold) {
                this.move('next');
            } else {
                this.updateTransform();
            }
            isDragging = false;
            this.wrapper.style.transition = 'transform 0.3s ease';
            if (pointerEventsDisabled) {
                setVideosPointerEvents('auto');
                pointerEventsDisabled = false;
            }
        };

        const onMouseDown = e => onDragStart(e.clientX);
        const onMouseMove = e => {
            if (!isDragging) return;
            cancelAnimationFrame(animationFrame);
            animationFrame = requestAnimationFrame(() => onDragMove(e.clientX));
        };
        const onMouseUp = onDragEnd;

        const onTouchStart = e => onDragStart(e.touches[0].clientX);
        const onTouchMove = e => {
            if (!isDragging) return;
            cancelAnimationFrame(animationFrame);
            animationFrame = requestAnimationFrame(() => onDragMove(e.touches[0].clientX));
        };
        const onTouchEnd = onDragEnd;

        this.wrapper.addEventListener('mousedown', onMouseDown);
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);

        this.wrapper.addEventListener('touchstart', onTouchStart, { passive: true });
        document.addEventListener('touchmove', onTouchMove, { passive: false });
        document.addEventListener('touchend', onTouchEnd);
    }
}
