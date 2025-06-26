<?php
$pdo = new PDO('mysql:host=localhost;dbname=bib;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$query = $pdo->query("SELECT * FROM categories");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);




// Récupérer toutes les catégories3
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les livres si une catégorie est sélectionnée
$livres = [];
if (isset($_GET['id_categorie'])) {
  $stmt = $pdo->prepare("SELECT * FROM livres WHERE id_categorie = :id");
  $stmt->execute([':id' => $_GET['id_categorie']]);
  $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
      border-top: 1px solid #111827;
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
        <!-- <p class="subtitle">
          Simplifiez la gestion de votre bibliothèque grâce à
          notre plateforme moderne et intuitive.
          Library Manager vous permet de suivre les emprunts,
          gérer les collections, consulter les disponibilités et
          bien plus encore, le tout depuis une seule interface.
        </p> -->
        <section class="catalogue">
          <div class="grid">
            <?php foreach ($categories as $cat): ?>
              <div class="card" onclick="window.location.href='?id_categorie=<?= $cat['id_categorie'] ?>#livres'">
                <h3><?= htmlspecialchars($cat['nom_categorie']) ?></h3>
                <?php if ($cat['image']): ?>
                  <img src="<?= htmlspecialchars($cat['image']) ?>" alt="Image catégorie" width="150">
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </section>



        <div class="livre-grid" id="livres">
          <?php if (!empty($livres)): ?>
            <h2>Livres dans la catégorie «
              <?= htmlspecialchars($categories[array_search($_GET['id_categorie'], array_column($categories, 'id_categorie'))]['nom_categorie']) ?>
              »
            </h2>
            <div class="livre-card">
              <?php foreach ($livres as $livre): ?>
                <div class="livre-items">
                  <strong><?= htmlspecialchars($livre['titre']) ?></strong><br>
                  Auteur : <b><?= htmlspecialchars($livre['auteur']) ?></b><br>
                  Éditeur : <b><?= htmlspecialchars($livre['editeur']) ?></b><br>
                  Année : <b><?= htmlspecialchars($livre['annee']) ?></b><br>
                  Quantité disponible : <b><?= htmlspecialchars($livre['quantite_total']) ?></b><br><br>
                  <?= $livre['quantite_total'] <= 0 ? '<i style="color: red; font-size: 16px;">Non disponible</i>' : '' ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>


    </div>

    <style>
      .categorie-card {
        display: inline-block;
        border: 1px solid #ccc;
        margin: 10px;
        padding: 20px;
        cursor: pointer;
        text-align: center;
        width: 200px;
      }

      .livre-grid {
        display: flex;
        flex-direction: column;
        background-color: #1f2937;
        gap: 50px;
        border-radius: 12px;
        padding: 20px;
        max-width: 1200px;
        margin: 30px auto;
      }


      .livre-card {
        border-radius: 12px;
        overflow: hidden;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        /* flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-arround;
        align-items: center; */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
      }

      .livre-items {
        /* width: 250px; */
        /* height: 260px; */
        border: 1px solid #ccc;
        margin: 5px;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 4px 8px #1f2937;
        text-align: left;
      }

      .livre-items strong {
        margin: 0;
        width: 300px;
        font-size: 22px;
        color: rgb(37, 235, 47);
        /* background-color: white; */
      }

      .livre-items b {
        color: rgb(95, 143, 255);
      }

    </style>




    <?php include '../includes/footer.php'; ?>

    <script src="./resources/js/menu.js"></script>
</body>

</html>