<?php

$pdo = new PDO('mysql:host=localhost;dbname=bib;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

// On suppose que la table emprunts a les colonnes id_emprunt, id_livre, id_utilisateur, date_emprunt, date_retour, statut
$query = $pdo->query(
    "SELECT e.*, l.titre, u.nom, u.prenom
       FROM emprunts e
       JOIN livres l ON e.id_livre = l.id_livre
       JOIN usagers u ON e.id_usager = u.id_usager
       WHERE e.statut =  'en_cours' OR e.statut =  'en_retard' 
       ORDER BY e.date_emprunt DESC"
);
$emprunts = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<?php
$pdo = new PDO("mysql:host=localhost;dbname=bib;charset=utf8", "root", "");

// Récupérer les usagers
$query_usagers = $pdo->query("SELECT * FROM usagers");
$usagers = $query_usagers->fetchAll();

// Récupérer les livres disponibles
$query_livres = $pdo->query("SELECT * FROM livres WHERE quantite_total > 0");
$livres = $query_livres->fetchAll();
?>

<?php
$form = $_GET['form'] ?? 'list-book'; // 'add-user' par défaut
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

    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div id="popup-message" class="popup <?= isset($_SESSION['success']) ? 'success' : 'error' ?>">
            <?= $_SESSION['success'] ?? $_SESSION['error'] ?>
        </div>
        <?php
        unset($_SESSION['success']);
        unset($_SESSION['error']);
        ?>
    <?php endif; ?>




    <div class="section">


        <div class="logo-and-links">
            <div class="nav-links options">


                <a href="/Library/views/gestion.php?form=list-book" style="border:1px solid #d1d5db"
                    class="nav-link <?php echo ($form === 'list-book') ? 'active-submenu' : ''; ?>">Lister les
                    Livres</a>
                <a href="/Library/views/gestion.php?form=list-user" style="border:1px solid #d1d5db"
                    class="nav-link <?php echo ($form === 'list-user') ? 'active-submenu' : ''; ?>">Lister les
                    Utilisateurs</a>
                <a href="/Library/views/gestion.php?form=list-borrow" style="border:1px solid #d1d5db"
                    class="nav-link <?php echo ($form === 'list-borrow') ? 'active-submenu' : ''; ?>">Lister les
                    emprunts</a>
                <a href="/Library/views/gestion.php?form=add-user" style="border:1px solid #d1d5db"
                    class="nav-link <?php echo ($form === 'add-user') ? 'active-submenu' : ''; ?>">Ajouter un
                    Utilisateur</a>
                <a href="/Library/views/gestion.php?form=add-book" style="border:1px solid #d1d5db"
                    class="nav-link <?php echo ($form === 'add-book') ? 'active-submenu' : ''; ?>">Ajouter un Livre</a>
                <a href="/Library/views/gestion.php?form=register-borrow" style="border:1px solid #d1d5db"
                    class="nav-link <?php echo ($form === 'register-borrow') ? 'active-submenu' : ''; ?>">Enregistrer un
                    emprunt</a>
            </div>
        </div>

        <section class="auth-section" id="auth">

            <?php if ($form === 'add-user'): ?>
                <!-- Formulaire Ajout Utilisateur -->
                <div class="auth-container">
                    <form action="../controllers/addUser.php" method="POST">
                        <div class="form-group"><label>Nom</label><input type="text" name="nom" required></div>
                        <div class="form-group"><label>Prénom</label><input type="text" name="prenom" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                        <div class="form-group"><label>Téléphone</label><input type="tel" name="telephone" required></div>
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
            <?php elseif ($form === 'add-book'): ?>
                <!-- Formulaire Ajout Livre -->
                <div class="auth-container">
                    <form action="../controllers/addBook.php" method="POST">
                        <div class="form-group"><label>Titre</label><input type="text" name="titre" required></div>
                        <div class="form-group"><label>Auteur</label><input type="text" name="auteur" required></div>
                        <div class="form-group"><label>Éditeur</label><input type="text" name="editeur"></div>
                        <div class="form-group"><label>Année</label><input type="number" name="annee" min="1900" max="2099">
                        </div>
                        <div class="form-group"><label>ISBN</label><input type="text" name="isbn"></div>
                        <div class="form-group"><label>Quantité</label><input type="number" name="quantite_total" min="1"
                                required></div>
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
            <?php elseif ($form === 'edit-book' && isset($_GET['id'])): ?>
                <?php
                $id = $_GET['id'];
                $stmt = $pdo->prepare("SELECT * FROM livres WHERE id_livre = ?");
                $stmt->execute([$id]);
                $livre = $stmt->fetch();
                ?>
                <div class="auth-container">
                    <h2>Modifier le Livre</h2>
                    <form action="../controllers/updateBook.php" method="POST">
                        <input type="hidden" name="id_livre" value="<?= $livre['id_livre'] ?>">
                        <div class="form-group"><label>Titre</label><input type="text" name="titre"
                                value="<?= htmlspecialchars($livre['titre']) ?>" required></div>
                        <div class="form-group"><label>Auteur</label><input type="text" name="auteur"
                                value="<?= htmlspecialchars($livre['auteur']) ?>" required></div>
                        <div class="form-group"><label>Éditeur</label><input type="text" name="editeur"
                                value="<?= htmlspecialchars($livre['editeur']) ?>"></div>
                        <div class="form-group"><label>Année</label><input type="number" name="annee"
                                value="<?= htmlspecialchars($livre['annee']) ?>" min="1900" max="2099"></div>
                        <div class="form-group"><label>ISBN</label><input type="text" name="isbn"
                                value="<?= htmlspecialchars($livre['isbn']) ?>"></div>
                        <div class="form-group"><label>Quantité</label><input type="number" name="quantite_total"
                                value="<?= htmlspecialchars($livre['quantite_total']) ?>" min="1" required></div>
                        <button type="submit">Mettre à jour</button>
                    </form>
                </div>

            <?php elseif ($form === 'list-book'): ?>


                <!-- Liste des livres -->
                <?php include "../Livres/listBook.php"; ?>
            <?php elseif ($form === 'list-user'): ?>
                <!-- Liste des utilisateurs -->
                <?php include "../Usagers/listUser.php"; ?>


            <?php elseif ($form === 'list-borrow'): ?>
                <!-- Liste des emprunts -->
                <?php include "../Emprunts/listBorrow.php" ?>
            <?php elseif ($form === 'register-borrow'): ?>
                <!-- Enregistrement d’un emprunt -->
                <div class="nouveau" style="margin: 2%">
                    <h2>Nouveau Usager</h2>
                    <form action="../controllers/registerUserAndBorrow.php" method="POST">
                        <div class="form-group"><label>Nom</label><input type="text" name="nom" required></div>
                        <div class="form-group"><label>Prénom</label><input type="text" name="prenom" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                        <div class="form-group"><label>Téléphone</label><input type="tel" name="telephone" required></div>
                        <div class="form-group"><label>Livre</label>
                            <select name="id_livre" required>
                                <option value="">Choisir un livre</option>
                                <?php foreach ($livres as $livre): ?>
                                    <option value="<?= $livre['id_livre'] ?>">
                                        <?= htmlspecialchars($livre['titre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Durée d'emprunt</label>
                            <select name="duree_emprunt" required>
                                <?php for ($i = 7; $i <= 15; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> jours</option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <button type="submit">Enregistrer</button>
                    </form>
                </div>


                <div class="existant" style="margin: 2%">
                    <h2>Usager Existant</h2>
                    <form action="../controllers/registerBorrow.php" method="POST">

                        <!-- Sélection de l'usager -->
                        <div class="form-group">
                            <label>Usager</label>
                            <select name="id_usager" required>
                                <option value="">Choisir un usager</option>
                                <?php foreach ($usagers as $usager): ?>
                                    <option value="<?= $usager['id_usager'] ?>">
                                        <?= htmlspecialchars($usager['prenom'] . ' ' . $usager['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Sélection du livre -->
                        <div class="form-group">
                            <label>Livre</label>
                            <select name="id_livre" required>
                                <option value="">Choisir un livre</option>
                                <?php foreach ($livres as $livre): ?>
                                    <option value="<?= $livre['id_livre'] ?>">
                                        <?= htmlspecialchars($livre['titre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Durée d'emprunt</label>
                            <select name="duree_emprunt" required>
                                <?php for ($i = 7; $i <= 15; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> jours</option>
                                <?php endfor; ?>
                            </select>
                        </div>


                        <button type="submit">Enregistrer</button>
                    </form>
                </div>


            <?php endif; ?>

        </section>



    </div>
    </div>
    </div>





    <?php include '../includes/footer.php'; ?>

    <script src="../resources/js/menu.js"></script>

    <script>
        setTimeout(() => {
            const popup = document.getElementById('popup-message');
            if (popup) popup.style.display = 'none';
        }, 4000);
    </script>

</body>

</html>

<script>
    function toggleForm() {
        const addUser = document.getElementById('add-user');
        const registerForm = document.getElementById('register-form');

        // Toggle visibility
        if (addUser.style.display === 'none') {
            addUser.style.display = 'block';
            registerForm.style.display = 'none';
        } else {
            addUser.style.display = 'none';
            registerForm.style.display = 'block';
        }
    }

</script>


<style>
    .auth-section {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 20px;
        width: 90%;
        margin: 1% auto;
        /* background-color: #f3f4f6; */
        font-family: sans-serif;
    }

    .auth-container {
        background-color: white;
        padding: 0 40px 10px 40px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        /* max-width: 400px; */
    }


    .auth-container a {
        text-decoration: none;
    }

    .nouveau {
        background-color: white;
        padding: 0 40px 10px 40px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 90%;

    }

    .nouveau form {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }


    .nouveau .form-group {
        width: 40%;
        margin: auto;
    }

    .existant {
        background-color: white;
        padding: 0 40px 10px 40px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 30%;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #1f2937;
        text-decoration: underline;
        text-underline-offset: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #374151;
    }

    .form-group input,
    .form-group select {
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



<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin: 0;
        /* margin: 40px auto; */
        background: #fff;
        border-radius: 12px;
        border: 1px solid white;
        overflow: hidden;
    }

    h2 {
        font-size: rem;
        font-weight: 600;
        /* color: white; */
    }

    th,
    td {
        padding: 12px 18px;
        border-bottom: 1px solid #ccc;
        text-align: left;
        color: #1f2937;
    }

    tr:hover {
        backgorund-color: red;
    }

    th {
        background: #1f2937;
        color: #fff;
        font-weight: 600;
    }

    tr:last-child td {
        border-bottom: none;
    }


    .btn-action {
        display: flex;
        align-items: center;
        /* justify-content: center; */
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

    .delete-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        margin: 0px;
        color: red;
        background-color: transparent;
        transition: background-color 0.3s ease;
    }

    .set-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        margin: 0px;
        border: 1px solid rgb(37, 235, 47);
        color: rgb(37, 235, 47);
        background-color: transparent;
        transition: background-color 0.3s ease;
    }

    .set-submit a {
        color: #111827
    }


    .delete-submit:hover {
        background-color: red;
        color: white;

    }

    .set-submit:hover {
        background-color: rgb(37, 235, 47);
        color: white;

    }

    .delete-submit img {
        margin: auto;
        width: 30px;
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


    .popup {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #1f2937;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        z-index: 10000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        opacity: 0.95;
        animation: fadeOut 4s forwards;
    }

    .popup.success {
        background-color: #10b981;
        /* vert */
    }

    .popup.error {
        background-color: #ef4444;
        /* rouge */
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        80% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            display: none;
        }
    }
</style>