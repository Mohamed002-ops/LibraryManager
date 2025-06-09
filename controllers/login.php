
<?php
session_start();
require_once './connectToDatabase.php';

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = $pdo->prepare("SELECT id_usager, prenom, nom, email, numero_carte FROM usagers WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();

        if ($password === $user['numero_carte']) {
            $stmtPhoto = $pdo->prepare("SELECT photo_profil FROM usagers WHERE id_usager = ?");
            $stmtPhoto->execute([$user['id_usager']]);
            $photo = $stmtPhoto->fetchColumn();

            $_SESSION['user'] = [
                'id_usager' => $user['id_usager'],
                'prenom' => $user['prenom'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'photo_url' => $photo 
                    ? '/LibraryManager/controllers/show_profile_photo.php?id=' . $user['id_usager']
                    : '/LibraryManager/resources/images/default-avatar.png'
            ];
            header('Location: ../views/accueil.php');
            exit;
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun compte trouvé.";
    }
}
