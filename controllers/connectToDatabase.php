<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=bib;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>