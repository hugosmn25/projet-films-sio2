<?php

/**
 * Contrôleur pour la gestion des genres
 * Gère les actions CRUD pour les genres
 */

require_once __DIR__ . '/../repositories/filmRepository.php';
require_once __DIR__ . '/../repositories/genreRepository.php';

function listeGenres() {
    $genres = getAllGenres();

    // Récupération des messages depuis la session
    $error = getErrorMessage();
    $success = getSuccessMessage();

    // Gestion des erreurs de chargement des genres
    if ($genres === false) {
        $error = "Erreur lors du chargement des genres";
    }

    include __DIR__ . '/../../templates/films/genre.php';
}