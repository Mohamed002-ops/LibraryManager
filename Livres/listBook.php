<!-- Liste des livres -->
<div class="auth-container section" style="padding: 0;">
    <table>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Editeur</th>
            <th>Annee</th>
            <th>ISBN</th>
            <th colspan="2">Action</th>
        </tr>
        <?php if (empty($livres)): ?>
            <tr>
                <td style="color: red;"><?= "Pas de livre disponible." ?></td>
            </tr>
        <?php endif ?>
        <?php foreach ($livres as $livre): ?>
            <tr>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                <td><?= htmlspecialchars($livre['editeur']) ?></td>
                <td><?= htmlspecialchars($livre['annee']) ?></td>
                <td><?= htmlspecialchars($livre['isbn']) ?></td>
                <!-- <td><?= htmlspecialchars($livre['quantite_total']) ?></td> -->
                <td>
                    <div class="btn-action">

                        <form action="../controllers/deleteBook.php" method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                            <input type="hidden" name="id_livre" value="<?= $livre['id_livre'] ?>">
                            <button type="submit" class="delete-submit">🗑️ Supprimer</button>
                        </form>
                        <button class="set-submit">
                            <a href="gestion.php?form=edit-book&id=<?= $livre['id_livre'] ?>">✏️ Modifier</a>
                        </button>

                    </div>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>