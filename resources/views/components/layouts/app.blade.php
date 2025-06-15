<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ucfirst($section) }} - FlirtFan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .icon {
            mask-image: url("{{ asset('img/icons.png') }}");
        }
    </style>
</head>

<body class="{{ $section === 'login' || $section === 'register' ? 'body--auth' : '' }}">

    {!! view('components.public.header', ['section' => $section])->render() !!}
    {!! $section !== 'login' && $section !== 'register' ? view('components.public.navbar')->render() : '' !!}

    <main class="main">
        {{ $slot }}
    </main>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let menuHtml = `@include('components.public.menu')`; // Blade será procesado por Laravel

            let currentDropdown = null;

            function isVisible(el) {
                return el.offsetParent !== null;
            }

            function getActiveDropdown() {
                return Array.from(document.querySelectorAll('.menu-btn')).find(isVisible);
            }

            function removeMenu() {
                const existingMenu = document.querySelector('.menu');
                if (existingMenu) {
                    existingMenu.remove();
                }
            }

            function addMenu(dropdown) {
                removeMenu(); // elimina cualquier menú previo
                dropdown.insertAdjacentHTML('beforeend', menuHtml);
                currentDropdown = dropdown;
            }

            // Evento para click en .menu-dropdown
            document.querySelectorAll('.menu-container').forEach(menuContainer => {
                menuContainer.addEventListener('click', () => {
                    const alreadyOpen = menuContainer.querySelector('.menu');
                    if (alreadyOpen) {
                        removeMenu();
                    } else {
                        addMenu(menuContainer);
                    }
                });
            });

            // Detectar cambios en el tamaño de pantalla y limpiar el menú si cambia el dropdown activo
            let lastActiveDropdown = getActiveDropdown();

            window.addEventListener('resize', () => {
                const newActiveDropdown = getActiveDropdown();

                // Si cambió el dropdown activo, eliminar el menú
                if (newActiveDropdown !== lastActiveDropdown) {
                    removeMenu();
                    lastActiveDropdown = newActiveDropdown;
                }
            });
        });
    </script>
</body>

</html>
