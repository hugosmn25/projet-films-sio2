<?php
$title = 'Liste des Films';
ob_start();
?>

<div class="card">
    <h2>Liste des Films</h2>

    <!-- Formulaire de recherche -->
    <form method="GET" class="search-form">
        <input type="hidden" name="action" value="search">
        <input type="text" name="search" placeholder="Rechercher par titre ou réalisateur..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit" class="btn">Rechercher</button>
        <a href="index.php?action=index" class="btn btn-warning">Effacer</a>
    </form>

    <!-- Bouton d'ajout -->
    <div style="margin-bottom: 1rem;">
        <a href="index.php?action=create" class="btn btn-success">Ajouter un Film</a>
    </div>

    <?php if (empty($films)): ?>
        <p>Aucun film trouvé.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Réalisateur</th>
                    <th>Année</th>
                    <th>Durée</th>
                    <th>Genre</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($films as $film): ?>
                    <tr>
                        <td><?= htmlspecialchars($film['titre']) ?></td>
                        <td><?= htmlspecialchars($film['realisateur']) ?></td>
                        <td><?= $film['annee'] ?></td>
                        <td><?= $film['duree'] ?> min</td>
                        <td><?= htmlspecialchars($film['genre_nom']) ?></td>
                        <td>
                            <?php if ($film['note'] > 0): ?>
                                <?= number_format($film['note'], 1) ?>/10
                            <?php else: ?>
                                Non noté
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="index.php?action=show&id=<?= $film['id'] ?>" class="btn">Voir</a>
                            <a href="index.php?action=edit&id=<?= $film['id'] ?>" class="btn btn-warning">Modifier</a>
                            <a href="index.php?action=delete&id=<?= $film['id'] ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>