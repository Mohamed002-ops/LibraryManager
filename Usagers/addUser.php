<?php
// Connexion à la base de données
include "../controllers/connectToDatabase.php";

$query_usagers = $pdo->query("SELECT * FROM usagers");
$usagers = $query_usagers->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    header("Location: ../index.php");
    exit;
} else {
    echo "Erreur lors de l'inscription.";
}

}
?>


<div class="auth-container">
    <form action="./" method="POST">
        <div class="form-group"><label>Nom</label><input type="text" name="nom" required></div>
        <div class="form-group"><label>Prénom</label><input type="text" name="prenom" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Téléphone</label><input type="tel" name="telephone" required></div>
        <button type="submit">Ajouter</button>
    </form>
</div>