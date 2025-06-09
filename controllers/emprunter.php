<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_usager'])) {
    $_SESSION['errors'][] = "Veuillez vous connecter pour emprunter un livre.";
    header("Location: ../index.php#login-form"); // Redirige vers la page de connexion
    exit;
}

$pdo = new PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_livre'])) {
    $id_livre = (int)$_POST['id_livre'];
    $id_usager = $_SESSION['user']['id_usager'];

    try {
        // Vérifier la quantité disponible
        $stmt = $pdo->prepare("SELECT quantite_total FROM livres WHERE id_livre = :id");
        $stmt->execute([':id' => $id_livre]);
        $livre = $stmt->fetch();

        if (!$livre) {
            $_SESSION['errors'][] = "Livre introuvable.";
        } elseif ($livre['quantite_total'] <= 0) {
            $_SESSION['errors'][] = "Ce livre n'est plus disponible.";
        } else {
            // Enregistrer l'emprunt
            $sql = "INSERT INTO emprunts (id_usager, id_livre, date_emprunt, duree_jours)
                    VALUES (:id_usager, :id_livre, CURDATE(), 14)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_usager' => $id_usager,
                ':id_livre' => $id_livre
            ]);

            // Diminuer la quantité
            $update = $pdo->prepare("UPDATE livres SET quantite_total = quantite_total - 1 WHERE id_livre = :id");
            $update->execute([':id' => $id_livre]);

            $_SESSION['success'] = "Livre emprunté avec succès.";
        }
    } catch (PDOException $e) {
        $_SESSION['errors'][] = "Erreur : " . $e->getMessage();
    }
}

header("Location: ../views/accueil.php");
exit;
