@push('styles')
    {{-- Estilos específicos para la sección de reels --}}
    @vite('resources/css/videos.css')
@endpush

@push('scripts')
    {{-- Scripts específicos para la sección de reels --}}
    @vite('resources/js/videos.js')
@endpush

{{-- Add CSRF token for AJAX requests --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-layouts.app section="videos">

    <!-- Controles globales y contenedor de comentarios -->
    <div class="videos__container">

        <!-- Contenedor principal de los reproductores de video visibles (prev, current, next) -->
        <div class="videos__players">
            <!-- Los reproductores se crearán dinámicamente con JavaScript -->
        </div>

        <!-- Controles de navegación entre reels -->
        <div class="videos__btns">
            <button type="button" data-dir="prev" aria-label="Previous video" disabled>
                <i class="icon icon-up-angle-bracket"></i>
            </button>
            <button type="button" data-dir="next" aria-label="Next video">
                <i class="icon icon-down-angle-bracket"></i>
            </button>
        </div>

        <!-- Contenedor de comentarios dinámicos del reel actual -->
        <div class="videos__comments" data-comments-for="current"></div>
    </div>

</x-layouts.app>
