<?php
session_start();
session_unset();      // Supprime toutes les variables de session
session_destroy();    // Détruit la session

// Redirection vers la page d'accueil ou de connexion
header('Location: /LibraryManager/index.php');
exit;
