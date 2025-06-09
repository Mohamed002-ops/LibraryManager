<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $userId = $_SESSION['user']['id_usager'];

    try {
        // Mise à jour des infos de l’usager
        $sql = "UPDATE usagers SET prenom = :prenom, nom = :nom, email = :email WHERE id_usager = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':id' => $userId
        ]);

        // Mise à jour ou insertion de la photo si envoyée
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($_FILES['photo']['tmp_name']);

            // Vérifie si une photo existe déjà
            $checkStmt = $pdo->prepare("SELECT id_photo FROM photos_usagers WHERE id_usager = :id");
            $checkStmt->execute([':id' => $userId]);

            if ($checkStmt->rowCount() > 0) {
                // Mise à jour
                $updatePhoto = $pdo->prepare("UPDATE photos_usagers SET photo_profil = :photo WHERE id_usager = :id");
                $updatePhoto->execute([
                    ':photo' => $imageData,
                    ':id' => $userId
                ]);
            } else {
                // Insertion
                $insertPhoto = $pdo->prepare("INSERT INTO photos_usagers (id_usager, photo_profil) VALUES (:id, :photo)");
                $insertPhoto->execute([
                    ':id' => $userId,
                    ':photo' => $imageData
                ]);
            }
        }

        // Mise à jour de la session
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['nom'] = $nom;
        $_SESSION['user']['email'] = $email;

        $_SESSION['success'] = "Profil mis à jour avec succès.";
    } catch (PDOException $e) {
        $_SESSION['errors'] = ["Erreur base de données : " . $e->getMessage()];
    }

    header('Location: ../views/accueil.php');
    exit;
}
?>
