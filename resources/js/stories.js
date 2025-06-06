import { initSliderIfNeeded, moveSlider, enableSliderDragging } from './slider.js';


document.addEventListener('DOMContentLoaded', function () {
    const storiesContainer = document.querySelector('.stories');
    if (!storiesContainer) return;

    storiesContainer.addEventListener('click', function (e) {
        const target = e.target.closest('[data-action="swipeSlider"]');
        if (!target) return;

        const btn = target.closest(".slider-btn");
        if (!btn) return;
        const slider = btn.closest(".slider-container");
        if (!slider) return;

        // Si aún no estuvo inicializado, lo inicializamos ahora:
        initSliderIfNeeded(slider);

        const dir = btn.dataset.dir; // "prev" | "next" | "0" | "1" | ...
        moveSlider(slider, dir);
    });
});