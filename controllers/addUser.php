<?php
// Connexion à la base de données
include "./connectToDatabase.php";

// Récupération des données
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];

// Vérifier si l’email existe déjà
$stmt = $pdo->prepare("SELECT id_usager FROM usagers WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    echo "Email déjà utilisé.";
    exit;
}

// Insertion dans la base
$insert = $pdo->prepare("INSERT INTO usagers (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
if ($insert->execute([$nom, $prenom, $email, $telephone])) {
    header("Location: ../index.php?form=login#auth");
    exit;
} else {
    echo "Erreur lors de l'inscription.";
}


?>