<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// require_once '/LibraryManager/controllers/config/connectToDatabase.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("SELECT photo_profil FROM photos_usagers WHERE id_usager = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetchColumn();

    if ($photo) {
        header("Content-Type: image/jpeg"); // adapte à PNG si besoin
        echo $photo;
        exit;
    } else {
        // Pas de photo en base
        header("Location: ../resources/images/default-avatar.png");
        exit;
    }
} else {
    // Pas d'ID fourni
    header("Location: ../resources/images/default-avatar.png");
    exit;
}
?>