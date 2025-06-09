<?php
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
            <div class="logo-and-links">
                <!-- <img class="losgo" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company"> -->
                <div class="nav-links">
                    <a href="/LibraryManager"
                        class="nav-link <?php echo ($page === 'index') ? 'active' : ''; ?>">Dashboard</a>
                    <a href="/LibraryManager/views/catalogue.php"
                        class="nav-link <?php echo ($page === 'catalogue') ? 'active' : ''; ?>">Catalogue</a>
                    <a href="/LibraryManager/views/about.php"
                        class="nav-link <?php echo ($page === 'about') ? 'active' : ''; ?>">About Us</a>
                </div>
            </div>
            <div class="profile-section">

                <?php if (isset($_SESSION['user'])): ?>



                    <button class="notification-button">
                        <span class="sr-only">View notifications</span>
                        <svg class="icon" viewBox="0 0 24 24">
                            <path
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>
                    <div class="user-menu">
                        <button id="user-menu-button">
                            <img class="avatar"
                                src="<?php echo htmlspecialchars($_SESSION['user']['photo_url'] ?? '/LibraryManager/resources/images/default-avatar.png'); ?>"
                                alt="photo_profil">

                        </button>
                        <div class="dropdown hidden" id="user-dropdown">
                            <a href="/LibraryManager/views/profile-page.php">Your Profile</a>
                            <a href="#">Settings</a>
                            <a href="/LibraryManager/controllers/logout.php">Sign out</a>
                        </div>
                    </div>
                    <div class="user-menu">
                        <button id="user-menu-button" class="user-name-button">
                            <?php echo "<span class='user-name'>" . htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) . "</span>"; ?>
                        </button>
                        <div class="dropdown hidden" id="user-dropdown">
                            <a href="#">Profil</a>
                            <a href="#">Paramètres</a>
                            <a href="/LibraryManager/controllers/logout.php">Déconnexion</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="#login-form" onclick="toggleProfile(); return false;" class="nav-link btn-login">Se connecter</a>
            <?php endif; ?>

        </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden" id="mobile-menu">
        <a href="/LibraryManager" class="nav-link active">Dashboard</a>
        <a href="/LibraryManager/views/catalogue.php" class="nav-link">Catalogue</a>
        <a href="/LibraryManager/views/about.php" class="nav-link">About Us</a>
    </div>
</nav>

