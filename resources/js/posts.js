import Slider from './Slider.js';

document.addEventListener('DOMContentLoaded', function () {
    const postsContainer = document.querySelector('.posts');
    const sliders = new Map();

    function getSliderInstance(container) {
        if (!sliders.has(container)) {
            sliders.set(container, new Slider(container, {
                loop: false,
                autoplay: false,
                interval: 5000,
            }));
        }
        return sliders.get(container);
    }

    // ✅ Inicializar todos los sliders al cargar
    postsContainer.querySelectorAll('.slider-container').forEach(container => {
        getSliderInstance(container);
    });

    // Delegación de clics
    postsContainer.addEventListener('click', function (e) {
        const target = e.target.closest('[data-action="swipeSlider"]');
        if (!target) return;

        const btn = target.closest(".slider-btn");
        if (!btn) return;

        const container = btn.closest(".slider-container");
        const slider = getSliderInstance(container);
        const dir = btn.dataset.dir;
        slider.move(dir);
    });
});
