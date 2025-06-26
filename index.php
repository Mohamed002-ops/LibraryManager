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
        <h2 class="title">Bienvenue dans votre Library</h2>
        <p class="subtitle">
          Simplifiez la gestion de votre bibliothèque grâce à
          notre plateforme moderne et intuitive.
          Library Manager vous permet de suivre les emprunts,
          gérer les collections, consulter les disponibilités et
          bien plus encore, le tout depuis une seule interface.
        </p>

        <a href="#catalogue" class="cta-button" onclick="window.location.href='./views/catalogue.php'">Explorer le Catalogue</a>
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
      </div>
    </div>
  </div>


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
