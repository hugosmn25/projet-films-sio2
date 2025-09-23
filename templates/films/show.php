<?php
$title = 'Détails du Film';
ob_start();
?>

<div class="card">
    <?php if (isset($film) && $film): ?>
        <h2><?= htmlspecialchars($film['titre']) ?></h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 1rem;">
            <div>
                <p><span class="label">Réalisateur :</span> <?= htmlspecialchars($film['realisateur']) ?></p>
                <p><span class="label">Année :</span> <?= $film['annee'] ?></p>
                <p><span class="label">Durée :</span> <?= $film['duree'] ?> minutes</p>
                <p><span class="label">Genre :</span> <?= htmlspecialchars($film['genre_nom']) ?></p>
                <p><span class="label">Note :</span>
                    <?php if ($film['note'] > 0): ?>
                        <?= number_format($film['note'], 1) ?>/10
                    <?php else: ?>
                        Non noté
                    <?php endif; ?>
                </p>
            </div>

            <div>
                <?php if (!empty($film['synopsis'])): ?>
                    <p><span class="label">Synopsis :</span></p>
                    <p style="text-align: justify; line-height: 1.6;"><?= nl2br(htmlspecialchars($film['synopsis'])) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <a href="index.php?action=edit&id=<?= $film['id'] ?>" class="btn btn-warning">Modifier</a>
            <a href="index.php?action=index" class="btn">Retour à la liste</a>
        </div>

    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>