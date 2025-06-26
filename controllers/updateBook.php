<?php
session_start();
require_once '../controllers/connectToDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_livre'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $editeur = $_POST['editeur'];
    $annee = $_POST['annee'];
    $isbn = $_POST['isbn'];
    $quantite_total = $_POST['quantite_total'];

    try {
        $stmt = $pdo->prepare("UPDATE livres SET titre=?, auteur=?, editeur=?, annee=?, isbn=?, quantite_total=? WHERE id_livre=?");
        $stmt->execute([$titre, $auteur, $editeur, $annee, $isbn, $quantite_total, $id]);

        $_SESSION['success'] = "Livre modifié avec succès.";
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour.";
    }

    header("Location: ../views/gestion.php?form=list-book");
    exit;
}
