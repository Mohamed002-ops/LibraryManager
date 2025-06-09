<?php
include '../controllers/config.php';

$query = $pdo->query("SELECT * FROM categories");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogue</title>
  <link rel="stylesheet" href="../resources/css/style.css">

  <style>
    /* style du catalogue */
    .catalogue {
      padding: 60px 20px;
      background-color: #1f2937;
      border-radius: 20px;
      text-align: center;
      font-family: sans-serif;
    }

    .catalogue h2 {
      font-size: 2.5rem;
      margin-bottom: 40px;
      color: #1f2937;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .card {
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .card img {
      width: 100%;
      height: 260px;
      /* object-fit: cover; */
    }

    .card h3 {
      margin: 15px 0;
      font-size: 1.2rem;
      color: #111827;
    }
  </style>
</head>

<body>


  <?php include "../includes/header.php"; ?>
  <div class="section">

    <div class="container">
      <div class="header">
        <h2 class="title">Catalogue</h2>
        <p class="subtitle">
          Simplifiez la gestion de votre bibliothèque grâce à
          notre plateforme moderne et intuitive.
          Library Manager vous permet de suivre les emprunts,
          gérer les collections, consulter les disponibilités et
          bien plus encore, le tout depuis une seule interface.
        </p>
        <section class="catalogue">
          <div class="grid">
            <?php foreach ($categories as $cat): ?>
              <div class="card" >
                <img src="<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['nom_categorie']) ?>">
                <h3><?= htmlspecialchars($cat['nom_categorie']) ?></h3>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      </div>


    </div>
  </div>
 

  <?php include '../includes/footer.php'; ?>

  <script src="./resources/js/menu.js"></script>
</body>

</html>