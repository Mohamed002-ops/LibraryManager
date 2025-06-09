<?php
session_start();
require_once '../config/database.php'; // Assure-toi que $pdo est bien initialisé ici

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $userId = $_SESSION['user']['id_usager'];

    // Gérer le téléchargement de la nouvelle photo
    $photo_url = $_SESSION['user']['photo_url'] ?? '/LibraryManager/resources/images/default-avatar.png';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = 'photo_user_' . $userId . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            $photo_url = $destination;
        }
    }

    try {
        $sql = "UPDATE usagers SET prenom = :prenom, nom = :nom, email = :email, photo_url = :photo_url WHERE id_usager = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':photo_url' => $photo_url,
            ':id' => $userId
        ]);

        // Mettre à jour la session
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['nom'] = $nom;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['photo_url'] = $photo_url;

        $_SESSION['success'] = "Profil mis à jour avec succès.";
    } catch (PDOException $e) {
        $_SESSION['errors'] = ["Erreur base de données : " . $e->getMessage()];
    }

    header('Location: ../views/accueil.php');
    exit;
}
?>
