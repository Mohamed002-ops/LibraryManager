<?php
session_start();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=bib;charset=utf8", "root", "");

// Vérifie que le formulaire a été soumis correctement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $id_livre = (int) ($_POST['id_livre'] ?? 0);
    $duree = isset($_POST['duree_emprunt']) ? (int)$_POST['duree_emprunt'] : 7;
    $date_retour = date('Y-m-d', strtotime("+$duree days"));
    
    // Vérifie si le livre existe et est disponible
    $stmt = $pdo->prepare("SELECT quantite_total FROM livres WHERE id_livre = ?");
    $stmt->execute([$id_livre]);
    $livre = $stmt->fetch();

    if (!$livre || $livre['quantite_total'] <= 0) {
        $_SESSION['errors'][] = "Ce livre n'est pas disponible.";
        header("Location: ../index.php");
        exit;
    }

    // Insérer l'usager
    $insertUsager = $pdo->prepare("INSERT INTO usagers (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
    $insertUsager->execute([$nom, $prenom, $email, $telephone]);
    $id_usager = $pdo->lastInsertId();

    // Insérer l'emprunt
    $insert = $pdo->prepare("INSERT INTO emprunts (id_usager, id_livre, date_emprunt, date_retour) VALUES (?, ?, CURDATE(), ?)");
    $insert->execute([$id_usager, $id_livre, $date_retour]);


    // Mettre à jour la quantité du livre
    $updateLivre = $pdo->prepare("UPDATE livres SET quantite_total = quantite_total - 1 WHERE id_livre = ?");
    $updateLivre->execute([$id_livre]);

    $_SESSION['success'] = "Emprunt enregistré avec succès.";
    header("Location: ../index.php");
    exit;
} else {
    $_SESSION['errors'][] = "Formulaire invalide.";
    header("Location: ../index.php");
    exit;
}
