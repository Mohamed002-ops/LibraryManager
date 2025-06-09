<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Example</title>
  <link rel="stylesheet" href="./resources/css/style.css">
</head>

<body>

  <?php include "./includes/header.php"; ?>
  <?php
$form = $_GET['form'] ?? 'login'; // login par défaut
$isLogin = $form === 'login';
?>


  <div class="section">

    <div class="container">
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

              include "./controllers/connectToDatabase.php";

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
              include "./controllers/connectToDatabase.php";

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
              include "./controllers/connectToDatabase.php";
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

  <section class="auth-section" id="auth">
    <div class="auth-container">
      <!-- Formulaire de Connexion -->
      <div id="login-form" style="<?= $isLogin ? '' : 'display: none;' ?>">
        <h2>Se connecter</h2>
        <form action="./controllers/login.php" method="POST">
          <div class="form-group">
            <label for="email_login">Email</label>
            <input type="email" name="email" id="email_login" required>
          </div>
          <div class="form-group">
            <label for="password_login">Mot de passe</label>
            <input type="password" name="password" id="password_login" required>
          </div>
          <button type="submit" name="login">Connexion</button>
        </form>
        <p class="toggle-text">Pas encore de compte ?
          <a href="?form=register#auth">Créer un compte</a>
        </p>
      </div>

      <!-- Formulaire d'inscription -->
      <div id="register-form" style="<?= !$isLogin ? '' : 'display: none;' ?>">
        <h2>Créer un compte</h2>
        <form action="./controllers/register.php" method="POST">
          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required>
          </div>
          <div class="form-group">
            <label for="nom">Prenom</label>
            <input type="text" name="prenom" id="prenom" required>
          </div>
          <div class="form-group">
            <label for="email_register">Email</label>
            <input type="email" name="email" id="email_register" required>
          </div>
          <div class="form-group">
            <label for="password_register">Mot de passe</label>
            <input type="password" name="password" id="password_register" required>
          </div>
          <button type="submit">S'inscrire</button>
        </form>
        <p class="toggle-text">Déjà un compte ?
          <a href="?form=login#auth">Se connecter</a>
        </p>
      </div>
    </div>
  </section>


  <style>
    html {
      scroll-behavior: smooth;
    }

    .auth-section {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
      background-color: #f3f4f6;
      font-family: sans-serif;
    }

    .auth-container {
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #1f2937;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #374151;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #1f2937;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .toggle-text {
      color: #374151;
      font-size: 14px;
      font-weight: bold;
      text-align: center;
      margin-top: 15px;
    }

    .toggle-text a {
      color: #2563eb;
      text-decoration: none;
    }

    .toggle-text a:hover {
      text-decoration: underline;
    }
  </style>


  <?php include './includes/footer.php'; ?>

  <script src="./resources/js/menu.js"></script>
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