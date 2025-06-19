document.addEventListener('DOMContentLoaded', function() {
    const menuContainer = document.querySelector('.menu-container');
    const menuBtn = document.querySelector('.menu-btn');
    const menu = document.querySelector('.menu');
    const closeBtn = menu.querySelector('[data-action="close"]');
    const menuItems = menu.querySelectorAll('li');

    // Function to toggle menu active state
    function toggleMenu() {
        menu.classList.toggle('active');
    }

    // Function to close menu
    function closeMenu() {
        menu.classList.remove('active');
    }

    // Open menu when clicking the menu button
    menuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenu();
    });

    // Close menu when clicking the close button
    closeBtn.addEventListener('click', closeMenu);

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!menuContainer.contains(e.target)) {
            closeMenu();
        }
    });

    // Close menu when clicking on any menu item
    menuItems.forEach(item => {
        item.addEventListener('click', closeMenu);
    });
}); 