// ----------------------------
// Función para inicializar cada slider UNA sola vez
// ----------------------------
function initSliderIfNeeded(sliderContainer) {
    // Si ya tenía data-initialized="true", salimos
    if (sliderContainer.dataset.initialized === "true") return;

    const wrapper = sliderContainer.querySelector(".slider-wrapper");
    if (!wrapper) return;

    // 3.1) Contar cuántos slides hay
    const slides = wrapper.querySelectorAll(".slide");
    sliderContainer.dataset.slidesCount = slides.length;
    sliderContainer.dataset.currentIndex = "0";

    // 3.2) Poner transform inicial (slide 0)
    wrapper.style.transform = "translateX(0%)";

    // 3.3) Desactivar botón ‹prev› al inicio
    const prevBtn = sliderContainer.querySelector('[data-dir="prev"]');
    if (prevBtn) prevBtn.classList.add("disabled");

    // 3.4) Marcar como inicializado
    sliderContainer.dataset.initialized = "true";
}

// ----------------------------
// Función moveSlider (igual que antes, con loop opcional)
// ----------------------------
function moveSlider(sliderContainer, dir, loop = false) {
    const wrapper = sliderContainer.querySelector(".slider-wrapper");
    const slidesCount = parseInt(sliderContainer.dataset.slidesCount, 10);
    let currentIndex = parseInt(sliderContainer.dataset.currentIndex || "0", 10);

    if (dir === "next") {
        if (currentIndex < slidesCount - 1) {
            currentIndex++;
        } else if (loop) {
            currentIndex = 0;
        }
    } else if (dir === "prev") {
        if (currentIndex > 0) {
            currentIndex--;
        } else if (loop) {
            currentIndex = slidesCount - 1;
        }
    } else {
        // Si dir es un número (string), lo convertimos
        const parsed = parseInt(dir, 10);
        if (!isNaN(parsed) && parsed >= 0 && parsed < slidesCount) {
            currentIndex = parsed;
        }
    }

    sliderContainer.dataset.currentIndex = currentIndex;

    if (wrapper) {
        wrapper.querySelectorAll(".slide").forEach(slide => {
            slide.style.transform = `translateX(-${currentIndex * 100}%)`;
        });
    }

    // Si no es loop, desactivamos prev/next en bordes
    if (!loop) {
        const prevBtn = sliderContainer.querySelector('[data-dir="prev"]');
        const nextBtn = sliderContainer.querySelector('[data-dir="next"]');
        if (prevBtn) prevBtn.classList.toggle("disabled", currentIndex === 0);
        if (nextBtn) nextBtn.classList.toggle("disabled", currentIndex === slidesCount - 1);
    }
}

// ----------------------------
// Función enableSliderDragging (solo engancha una vez por slider-wrapper)
// ----------------------------
function enableSliderDragging(sliderContainer, loop = false) {
    const wrapper = sliderContainer.querySelector(".slider-wrapper");
    if (!wrapper) return;

    // Si ya se había preparado para drag, salimos
    if (wrapper.dataset.dragReady === "true") return;
    wrapper.dataset.dragReady = "true";

    let isDragging = false;
    let startX = 0;
    let deltaX = 0;
    // OBS: currentIndex lo leeremos al inicio de cada drag

    const onMouseDown = (e) => {
        isDragging = true;
        startX = e.clientX;

        // Leemos el índice actual justo al arrancar el drag
        const baseIndex = parseInt(sliderContainer.dataset.currentIndex, 10);
        wrapper.dataset.baseIndex = baseIndex;

        // Desactivamos transición para movimiento en tiempo real
        wrapper.style.transition = "none";

        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
    };

    const onMouseMove = (e) => {
        if (!isDragging) return;
        sliderContainer.style.cursor = "grabbing"; // Cambiamos el cursor a "grabbing"
        const currentX = e.clientX;
        deltaX = currentX - startX;

        const width = sliderContainer.offsetWidth;
        const offsetPercent = (deltaX / width) * 100;
        const baseIndex = parseInt(wrapper.dataset.baseIndex, 10);

        // Movemos “en crudo” según desplazamiento
        wrapper.querySelectorAll(".slide").forEach(slide => {
            slide.style.transform = `translateX(calc(-${baseIndex * 100}% + ${offsetPercent}%))`
        });
    };

    const onMouseUp = () => {
        if (!isDragging) return;
        sliderContainer.style.cursor = "initial"; // Restauramos el cursor
        isDragging = false;

        const width = sliderContainer.offsetWidth;
        const movedPercent = (deltaX / width) * 100;
        const baseIndex = parseInt(wrapper.dataset.baseIndex, 10);

        if (movedPercent > 10) {
            // Arrastró suficiente hacia la derecha → prev
            moveSlider(sliderContainer, "prev", loop);
        } else if (movedPercent < -10) {
            // Arrastró suficiente hacia la izquierda → next
            moveSlider(sliderContainer, "next", loop);
        } else {
            // No llegó al 10% → volvemos al baseIndex
            wrapper.querySelectorAll(".slide").forEach(slide => {
                slide.style.transform = `translateX(-${baseIndex * 100}%)`;
            });
        }

        // Limpiar listeners de move/up
        document.removeEventListener("mousemove", onMouseMove);
        document.removeEventListener("mouseup", onMouseUp);
        deltaX = 0;
    };

    // Enganchamos el listener de drag al wrapper UNA sola vez
    wrapper.addEventListener("mousedown", onMouseDown);
}

export { initSliderIfNeeded, moveSlider, enableSliderDragging };