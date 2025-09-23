<?php
$title = 'Ajouter un Film';
ob_start();
?>

<div class="card">
    <h2>Ajouter un Film</h2>

    <form method="POST" action="index.php?action=create">
        <div class="form-group">
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($film['titre'] ?? '') ?>" required>
            <?php if (isset($errors['titre'])): ?>
                <div class="error"><?= htmlspecialchars($errors['titre']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="realisateur">Réalisateur *</label>
            <input type="text" id="realisateur" name="realisateur" value="<?= htmlspecialchars($film['realisateur'] ?? '') ?>" required>
            <?php if (isset($errors['realisateur'])): ?>
                <div class="error"><?= htmlspecialchars($errors['realisateur']) ?></div>
            <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="annee">Année *</label>
                <input type="number" id="annee" name="annee" value="<?= htmlspecialchars($film['annee'] ?? '') ?>" min="1800" max="<?= date('Y') + 5 ?>" required>
                <?php if (isset($errors['annee'])): ?>
                    <div class="error"><?= htmlspecialchars($errors['annee']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="duree">Durée (minutes) *</label>
                <input type="number" id="duree" name="duree" value="<?= htmlspecialchars($film['duree'] ?? '') ?>" min="1" max="600" required>
                <?php if (isset($errors['duree'])): ?>
                    <div class="error"><?= htmlspecialchars($errors['duree']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="genre_id">Genre *</label>
            <select id="genre_id" name="genre_id" required>
                <option value="">Sélectionner un genre</option>
                <?php if (isset($genres) && $genres): ?>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= $genre['id'] ?>"
                            <?= (isset($film['genre_id']) && $film['genre_id'] == $genre['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genre['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php if (isset($errors['genre_id'])): ?>
                <div class="error"><?= htmlspecialchars($errors['genre_id']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="note">Note (sur 10)</label>
            <input type="number" id="note" name="note" value="<?= htmlspecialchars($film['note'] ?? '') ?>" min="0" max="10" step="0.1">
            <?php if (isset($errors['note'])): ?>
                <div class="error"><?= htmlspecialchars($errors['note']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="synopsis">Synopsis</label>
            <textarea id="synopsis" name="synopsis" placeholder="Résumé du film..."><?= htmlspecialchars($film['synopsis'] ?? '') ?></textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-success">Créer le Film</button>
            <a href="index.php?action=index" class="btn">Annuler</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>