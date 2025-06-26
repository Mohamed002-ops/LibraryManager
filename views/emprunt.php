<?php
$pdo = new PDO('mysql:host=localhost;dbname=bib;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("UPDATE emprunts
             SET statut = 'en_retard'
             WHERE statut = 'en_cours'
               AND date_retour < CURDATE()");


// On suppose que la table emprunts a les colonnes id_emprunt, id_livre, id_utilisateur, date_emprunt, date_retour, statut
$query = $pdo->query(
  "SELECT e.*, l.titre, u.nom, u.prenom
     FROM emprunts e
     JOIN livres l ON e.id_livre = l.id_livre
     JOIN usagers u ON e.id_usager = u.id_usager
     ORDER BY e.date_emprunt DESC"
);
$emprunts = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Liste des emprunts</title>
  <link rel="stylesheet" href="../resources/css/style.css">
  <style>
    table {
      border-collapse: collapse;
      width: 90%;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      border: 1px solid white;
      overflow: hidden;
    }

    h2 {
      font-size: 3rem;
      font-weight: 600;
      color: white;
    }

    th,
    td {
      padding: 12px 18px;
      border-bottom: 1px solid #ccc;
      text-align: left;
      color: #1f2937;
    }

    th {
      background: #1f2937;
      color: #fff;
      font-weight: 500;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .emprunt-submit {
      background-color: rgb(37, 235, 47);
      color: #111827;
      border: none;
      font-size: 15px;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .emprunt-submit:hover {
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
      background-color: #111827;
      /* border: 1px solid rgb(37, 235, 47); */
      color: white;
    }

    .user-menu {
      /* border: 1px solid red; */
      width: 90%;
      display: flex;
      margin: auto;
      align-items: center;
      justify-content: right;
    }

    #user-menu-button {
      background: none;
      width: 40px;
      border: none;
      color: #ccc;
    }

    .dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      z-index: 9999;
      background: white;
      color: black;
      padding: 0.5rem 0;
      border-radius: 6px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
      min-width: 150px;
    }

    .dropdown a {
      padding: 0.5rem 1rem;
      text-decoration: none;
      color: #333;
    }

    .dropdown a:hover {
      background-color: black;
    }
  </style>
</head>

<body>
  <?php include "../includes/header.php"; ?>
  <div class="section">
    <div class="user-menu">
      <img src="../resources/images/menu-bar.png" alt="" id="user-menu-button">

      <div class="dropdown hidden" id="user-dropdown">
        <a href="#" id="filter-all">Tous les Emprunts</a>
        <a href="#" id="filter-current">Emprunt en cours</a>
        <a href="#" id="filter-available">Emprunt retourne</a>
        <a href="#" id="filter-available">Emprunt en retard</a>
      </div>
    </div>


    <h2 style="text-align:center; margin-top:40px;">Liste des emprunts</h2>
    <table>
      <tr>
        <th>Livre</th>
        <th>Emprunteur</th>
        <th>Date d'emprunt</th>
        <th>Date de retour</th>
        <th>Statut</th>
      </tr>
      <?php if (empty($emprunts)): ?>
        <tr>
          <td colspan="5" style="text-align:center; color:red;">Pas de livres empruntés</td>
        </tr>
      <?php endif; ?>
      <?php foreach ($emprunts as $emprunt): ?>
        <tr class="emprunt-row" data-statut="<?= $emprunt['statut'] ?>">
          <td><?= htmlspecialchars($emprunt['titre']) ?></td>
          <td><?= htmlspecialchars($emprunt['prenom'] . ' ' . $emprunt['nom']) ?></td>
          <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
          <td><?= htmlspecialchars($emprunt['date_retour']) ?></td>
          <td style="color: 
    <?php
    echo ($emprunt['statut'] == 'en_retard') ? 'red' :
      (($emprunt['statut'] == 'en_cours') ? 'blue' : 'green');
    ?>;">
            <?= htmlspecialchars($emprunt['statut']) ?>
          </td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>
  <?php include "../includes/footer.php"; ?>

</body>

</html>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const allRows = document.querySelectorAll('.emprunt-row');

    // Filtrer les lignes selon le statut
    function filterRows(statut) {
      allRows.forEach(row => {
        if (statut === 'Tous') {
          row.style.display = '';
        } else {
          row.style.display = row.dataset.statut === statut ? '' : 'none';
        }
      });
    }

    // Gérer les clics
    document.getElementById('filter-all').addEventListener('click', e => {
      e.preventDefault();
      filterRows('Tous');
    });

    document.getElementById('filter-current').addEventListener('click', e => {
      e.preventDefault();
      filterRows('en_cours');
    });

    // Pour "Livres disponibles" tu dois soit :
    // 1. Avoir une autre vue (si ce n'est pas des emprunts)
    // 2. Ne rien faire ici, ou cacher tous les emprunts

    document.getElementById('filter-available').addEventListener('click', e => {
      e.preventDefault();
      filterRows('retourne');
      // allRows.forEach(row => row.style.display = 'none'); // Ou redirige vers une autre page
    });
  });
</script>