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