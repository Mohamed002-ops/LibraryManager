
<h1>Mon Profil</h1>
<div class="profile-card">
    <img class="avatar-large"
        src="<?php echo htmlspecialchars($_SESSION['user']['photo_url'] ?? '/LibraryManager/resources/images/default-avatar.png'); ?>">

    <form method="post" action="../controllers/update_profil.php" enctype="multipart/form-data">
        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>

        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>

        <label>Email :</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Changer la photo :</label>
        <input type="file" name="photo">

        <button type="submit">Mettre à jour</button>
    </form>
</div>



<style>
    /* Titre */
    h1 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 2rem;
    }

    /* Carte profil */
    .profile-card {
        display: flex;
        flex-direction: row;
        width: 100%;
        /* max-width: 600px; */
        margin: 0 auto;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        flex-direction: column;
        align-items: center;
    }

    /* Avatar */
    .avatar-large {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #ccc;
        margin-bottom: 1.5rem;
    }

    /* Formulaire */
    form {
        width: 40%;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Étiquettes */
    form label {
        font-weight: bold;
        margin-bottom: 0.2rem;
    }

    /* Champs */
    form input[type="text"],
    form input[type="email"],
    form input[type="file"] {
        padding: 0.5rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: white;
    }

    /* Bouton */
    form button {
        padding: 0.7rem;
        font-size: 1rem;
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    form button:hover {
        background-color: #4338ca;
    }
</style>