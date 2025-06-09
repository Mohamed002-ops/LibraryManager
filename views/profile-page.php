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

        /* .user-name:hover {
            background-color: #374151;
            color: white;
        } */
    </style>
</head>

<body>

    <?php include "../includes/header.php"; ?>
    <?php
    $form = $_GET['form'] ?? 'login'; // login par défaut
    $isLogin = $form === 'login';
    ?>


    <div class="section">

        <!-- Juste après les statistiques ou à la fin -->
        <div id="profile-container">
            <?php include './profile-section.php'; ?>
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