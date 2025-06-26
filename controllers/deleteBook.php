<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=bib;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_livre'])) {
    $id = (int) $_POST['id_livre'];

    try {
        // Supprimer le livre
        $stmt = $pdo->prepare("DELETE FROM livres WHERE id_livre = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Livre supprimé avec succès.";
    } catch (Exception $e) {
        $_SESSION['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
    }
}

header("Location: ../views/gestion.php?form=list-book");
exit;
