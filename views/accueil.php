<?php
session_start();

$user = $_SESSION['user'];

?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    require_once 'config/db.php'; // ou ton fichier de connexion PDO

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <link rel="stylesheet" href="../resources/css/style.css">

    <style>
        .user-name {
            font-size: 1rem;
            font-weight: 600;
            color: white;
            padding: 10px;
            border-radius: 6px;
        }

        .user-name:hover {
            background-color: #374151;
            color: white;
        }
    </style>
</head>

<body>

    <?php include "../includes/header.php"; ?>
    <?php
    $form = $_GET['form'] ?? 'login'; // login par défaut
    $isLogin = $form === 'login';
    ?>


    <div class="section">

        <div class="container" id="stats-section">
            <div class="header">
                <h2 class="title">Bienvenu dans votre Library</h2>
                <p class="subtitle">
                    Simplifiez la gestion de votre bibliothèque grâce à
                    notre plateforme moderne et intuitive.
                    Library Manager vous permet de suivre les emprunts,
                    gérer les collections, consulter les disponibilités et
                    bien plus encore, le tout depuis une seule interface.
                </p>

                <a href="#catalogue" class="cta-button">Explorer le Catalogue</a>
            </div>

            <div class="stats">
                <div class="stat-item">
                    <span class="dt">Livres Disponibles</span>
                    <span class="dd">
                        <?php
                        try {

                            include "../controllers/connectToDatabase.php";

                            // Requête pour récupérer la somme des quantités
                            $query = $pdo->query("SELECT SUM(quantite_total) AS total_disponible FROM livres");
                            $result = $query->fetch();

                            // Affichage
                            echo ($result['total_disponible'] ?? 0);

                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                        ?>

                    </span>
                </div>
                <div class="stat-item">
                    <span class="dt">Utilisateurs du Library</span>
                    <span class="dd">
                        <?php
                        try {
                            include "../controllers/connectToDatabase.php";

                            // Requête pour récupérer la somme des quantités
                            $query = $pdo->query("SELECT COUNT(id_usager) AS total_user FROM usagers");
                            $result = $query->fetch();

                            // Affichage
                            echo ($result['total_user'] ?? 0);

                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                        ?>
                    </span>
                </div>
                <div class="stat-item">
                    <span class="dt">Livres Empruntés</span>
                    <span class="dd">
                        <?php
                        try {
                            include "../controllers/connectToDatabase.php";
                            // Requête pour récupérer la somme des quantités
                            $query = $pdo->query("SELECT COUNT(id_emprunt) AS total_emprunt FROM emprunts WHERE statut = 'en_cours'");
                            $result = $query->fetch();

                            // Affichage
                            echo ($result['total_emprunt'] ?? 0);

                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                        ?>
                    </span>
                </div>
                <!-- <div class="stat-item">
          <span class="dt">Paid time off</span>
          <span class="dd">Unlimited</span>
        </div> -->
            </div>
        </div>
    </div>





    <?php include '../includes/footer.php'; ?>

    <script src="../resources/js/menu.js"></script>
</body>

</html>

<script>
    function toggleForm() {
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        // Toggle visibility
        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        }
    }

</script>