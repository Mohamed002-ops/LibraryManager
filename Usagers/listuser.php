<!-- Liste des utilisateurs -->
<div class="auth-container section">
    <table>
        <tr>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>telephone</th>
        </tr>
        <?php if (empty($livres)): ?>
            <tr>
                <td style="color: red;"><?= "Pas de livre disponible." ?></td>
            </tr>
        <?php endif ?>
        <?php foreach ($usagers as $usager): ?>
            <tr>
                <td><?= htmlspecialchars($usager['prenom']) ?></td>
                <td><?= htmlspecialchars($usager['nom']) ?></td>
                <td><?= htmlspecialchars($usager['email']) ?></td>
                <td><?= htmlspecialchars($usager['telephone']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

