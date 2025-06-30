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
?>

<div class="auth-container">
    <form action="../controllers/addUser.php" method="POST">
        <div class="form-group"><label>Nom</label><input type="text" name="nom" required></div>
        <div class="form-group"><label>Prénom</label><input type="text" name="prenom" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Téléphone</label><input type="tel" name="telephone" required></div>
        <button type="submit">Ajouter</button>
    </form>
</div>