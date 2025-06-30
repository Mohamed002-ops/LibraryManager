<?php
session_start();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=bib;charset=utf8", "root", "");

// Vérifie que les données viennent bien du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usager'], $_POST['id_livre'])) {
    $id_usager = (int) $_POST['id_usager'];
    $id_livre = (int) $_POST['id_livre'];
    $duree = isset($_POST['duree_emprunt']) ? (int)$_POST['duree_emprunt'] : 7;
    $date_retour = date('Y-m-d', strtotime("+$duree days"));
    

    // Vérifier si le livre est encore disponible
    $stmt = $pdo->prepare("SELECT quantite_total FROM livres WHERE id_livre = ?");
    $stmt->execute([$id_livre]);
    $livre = $stmt->fetch();

    if ($livre && $livre['quantite_total'] > 0) {
        // Insérer l’emprunt
        $insert = $pdo->prepare("INSERT INTO emprunts (id_usager, id_livre, date_emprunt, date_retour) VALUES (?, ?, CURDATE(), ?)");
        $insert->execute([$id_usager, $id_livre, $date_retour]);

        // Diminuer la quantité du livre
        $update = $pdo->prepare("UPDATE livres SET quantite_total = quantite_total - 1 WHERE id_livre = ?");
        $update->execute([$id_livre]);

        $_SESSION['success'] = "Emprunt enregistré avec succès.";
    } else {
        $_SESSION['errors'][] = "Le livre n'est plus disponible.";
    }
} else {
    $_SESSION['errors'][] = "Formulaire incomplet.";
}

// Rediriger vers la page précédente
header("Location: ../views/gestion.php?form=list-borrow");
exit;

