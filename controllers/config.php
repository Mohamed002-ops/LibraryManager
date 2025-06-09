<?php
$host = 'localhost';
$dbname = 'bibliotheque';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // include "./connectToDatabase.php";
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>