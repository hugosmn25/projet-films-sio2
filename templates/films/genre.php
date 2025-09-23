<?php
$title = 'Liste des Genres';
ob_start();
?>

<h2>Liste des genres</h2>
<br>
<?php foreach ($genres as $genre): ?>
    <br>
    <li>
        <td><?= htmlspecialchars($genre['nom']) ?></td>
    </li>
<?php endforeach ?>



<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>