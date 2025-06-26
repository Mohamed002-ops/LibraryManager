<?php
session_start();
require_once '../controllers/connectToDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $editeur = trim($_POST['editeur']);
    $annee = $_POST['annee'] ?: null;
    $isbn = trim($_POST['isbn']);
    $quantite = intval($_POST['quantite_total']);

    try {
        $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, editeur, annee, isbn, quantite_total) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $auteur, $editeur, $annee, $isbn, $quantite]);

        $_SESSION['success'] = "📚 Livre ajouté avec succès.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'ajout du livre : " . $e->getMessage();
    }

    header('Location: ../views/gestion.php?form=add-book');
    exit;
}
