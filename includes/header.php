<?php
// session_start();
$page = basename($_SERVER['PHP_SELF'], '.php'); // 'index', 'library', etc.
?>

<nav class="navbar">
    <div class="container">
        <div class="nav-content">
            <div class="mobile-menu-button">
                <button id="menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg id="menu-icon-open" class="icon" viewBox="0 0 24 24">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg id="menu-icon-close" class="icon hidden" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="logo">

                <img src="/Library/resources/images/visitBook.png" alt="Your Company">
                LibraryManager
            </div>
            <div class="logo-and-links">
                <div class="nav-links">
                    <a href="/Library/index.php"
                        class="nav-link <?php echo ($page === 'index') ? 'active' : ''; ?>">Dashboard</a>
                    <a href="/Library/views/catalogue.php"
                        class="nav-link <?php echo ($page === 'catalogue') ? 'active' : ''; ?>">Catalogue</a>
                    <a href="/Library/views/emprunt.php"
                        class="nav-link <?php echo ($page === 'emprunt') ? 'active' : ''; ?>">Emprunts</a>
                    <a href="/Library/views/gestion.php"
                        class="nav-link <?php echo ($page === 'gestion') ? 'active' : ''; ?>">Gestion</a>
                    <!-- <a href="/Library/views/about.php"
                        class="nav-link <?php echo ($page === 'about') ? 'active' : ''; ?>">About Us</a> -->
                </div>
            </div>


        </div>
    </div>
</nav>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        toggleButton.addEventListener('click', () => {
            // const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('mobile-menu');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });
    });

</script>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    font-family: poppins;
}
    .navbar {
        background-color: #1f2937;
    }

    .container {
        transition: 0.3s ease-in-out, color 0.3s;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .nav-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 64px;
        position: relative;
    }



    .mobile-menu-button button {
        background: none;
        border: none;
        color: #ccc;
        padding: 0.5rem;
    }

    .logo {
        display: flex;
        flex-direction: row;
        align-items: center;
        font-size: 26px;
        color: #fff;
        text-shadow: 0 0 8px white;
    }

    .nav-links {
        display: flex;
        gap: 1rem;
        margin-left: 1rem;
    }

    .nav-link {
        text-decoration: none;
        color: #d1d5db;
        padding: 0.5rem 1rem;
        border-radius: 6px;
    }

    .options{
        display: flex;
        justify-content: space-around
    }

    .nav-link:hover {
        background-color: #374151;
        color: white;
    }

    .nav-link.active {
        background-color: #111827;
        color: white;
    }


    .active-submenu{
        color: #111827;
        background-color: white;
    }

    .profile-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .notification-button {
        background: none;
        border: none;
        color: #ccc;
    }

    .icon {
        width: 24px;
        height: 24px;
        stroke: currentColor;
        fill: none;
        padding: 10px;
        stroke-width: 1.5;
    }

    .icon:hover {
        background-color: #374151;
        color: white;
        border-radius: 20%;
    }

    .mobile-menu-button {
        display: none;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 9999px;
        border: 2px solid white;
    }

    .user-menu {
        position: relative;
    }

    #user-menu-button {
        background: none;
        border: none;
        color: #ccc;
    }

    .dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 9999;
        background: white;
        color: black;
        padding: 0.5rem 0;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        min-width: 150px;
    }

    .dropdown a {
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: #333;
    }

    .dropdown a:hover {
        background-color: #f3f4f6;
    }

    .mobile-menu {
        display: none;
        flex-direction: column;
        gap: 0.5rem;
        background-color: #1f2937;
        padding: 1rem;
    }

    .hidden {
        display: none;
    }

    .visible {
        display: block;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
</style>