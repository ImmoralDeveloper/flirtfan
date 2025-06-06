import { initSliderIfNeeded, moveSlider, enableSliderDragging } from './slider.js';
// event listener DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {
    const postsContainer = document.querySelector('.posts');

    // ----------------------------
    // 1) Delegación de clics para prev/next/paginación
    // ----------------------------
    postsContainer.addEventListener('click', function (e) {
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

    // ----------------------------
    // 2) Delegación de mousedown para arrastre
    // ----------------------------
    postsContainer.addEventListener('mouseover', function (e) {
        // Solo nos interesa sí el usuario presiona dentro de .slider-wrapper
        const wrapper = e.target.closest('.slider-wrapper');
        if (!wrapper) return;

        const slider = wrapper.closest('.slider-container');
        if (!slider) return;

        // Inicializamos el slider si no se había inicializado aún
        initSliderIfNeeded(slider);

        // Ahora activamos el "drag" para ese slider (solo una vez)
        enableSliderDragging(slider);
        // NOTA: enableSliderDragging engancha un listener 'mousedown' sobre el wrapper,
        //       pero como dentro chequeamos un flag data-drag-ready, no se duplica.
    });

});
