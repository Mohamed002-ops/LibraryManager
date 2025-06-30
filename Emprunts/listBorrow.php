<!-- Liste des emprunts -->
<div class="auth-container section" style="padding: 0;">
    <table>
        <tr>
            <th>Livre</th>
            <th>Emprunteur</th>
            <th>Date d'emprunt</th>
            <th>Date de retour</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php if (empty($emprunts)): ?>
            <tr>
                <td style="color: red;"><?= "Pas de livre empruntés" ?></td>
            </tr>
        <?php endif ?>
        <?php foreach ($emprunts as $emprunt): ?>
            <tr>
                <td><?= htmlspecialchars($emprunt['titre']) ?></td>
                <td><?= htmlspecialchars($emprunt['prenom'] . ' ' . $emprunt['nom']) ?></td>
                <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
                <td><?= htmlspecialchars($emprunt['date_retour']) ?></td>
                <td><?= htmlspecialchars($emprunt['statut']) ?></td>
                <td>
                    <form action="../controllers/return.php" method="POST">
                        <input type="hidden" name="id_livre" value="<?= $emprunt['id_livre'] ?>">
                        <button type="submit" class="emprunt-submit">📚 Rendre</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>