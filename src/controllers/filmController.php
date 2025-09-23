<?php

/**
 * Contrôleur pour la gestion des films
 * Gère les actions CRUD pour les films
 */

require_once __DIR__ . '/../repositories/filmRepository.php';
require_once __DIR__ . '/../repositories/genreRepository.php';

/**
 * Fonctions utilitaires pour la gestion des messages de session
 */

/**
 * Définit un message d'erreur dans la session
 * @param string $message Message d'erreur
 */
function setErrorMessage($message) {
    $_SESSION['error'] = $message;
}

/**
 * Définit un message de succès dans la session
 * @param string $message Message de succès
 */
function setSuccessMessage($message) {
    $_SESSION['success'] = $message;
}

/**
 * Récupère et supprime le message d'erreur de la session
 * @return string|null Message d'erreur ou null
 */
function getErrorMessage() {
    if (isset($_SESSION['error'])) {
        $message = $_SESSION['error'];
        unset($_SESSION['error']);
        return $message;
    }
    return null;
}

/**
 * Récupère et supprime le message de succès de la session
 * @return string|null Message de succès ou null
 */
function getSuccessMessage() {
    if (isset($_SESSION['success'])) {
        $message = $_SESSION['success'];
        unset($_SESSION['success']);
        return $message;
    }
    return null;
}

/**
 * Affiche la liste de tous les films
 */
function indexFilms() {
    $films = getAllFilms();
    // $genres = getAllGenres();

    // Récupération des messages depuis la session
    $error = getErrorMessage();
    $success = getSuccessMessage();

    // Gestion des erreurs de chargement des films
    if ($films === false) {
        $error = "Erreur lors du chargement des films";
    }

    include __DIR__ . '/../../templates/films/index.php';
}

/**
 * Affiche les détails d'un film
 */
function showFilm() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?action=index");
        exit;
    }

    $film = getFilmById($id);

    if (!$film) {
        setErrorMessage("Film non trouvé");
        header("Location: index.php?action=index");
        exit;
    }

    include __DIR__ . '/../../templates/films/show.php';
}

/**
 * Gère l'affichage du formulaire de création ET la soumission
 * Détecte automatiquement si c'est un GET (affichage) ou POST (soumission)
 */
function createFilm() {
    $genres = getAllGenres();

    // Détection de la soumission
    // A FAIRE

    // Gestion des erreurs de chargement des données
    if ($genres === false) {
        setErrorMessage("Erreur lors du chargement des genres");
        header("Location: index.php?action=index");
        exit;
    }

    include __DIR__ . '/../../templates/films/create.php';
}

/**
 * Gère l'affichage du formulaire de modification ET la soumission
 */
function editFilm() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?action=index");
        exit;
    }

    $film = getFilmById($id);
    $genres = getAllGenres();
    $errors = [];

    // Vérification que le film existe
    if (!$film) {
        setErrorMessage("Film non trouvé");
        header("Location: index.php?action=index");
        exit;
    }

    $error = null;

    // Détection de la soumission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = validateFilmData($_POST);

        if (empty($errors)) {
            $success = updateFilmData($id, $_POST);

            if ($success) {
                setSuccessMessage("Film modifié avec succès");
                header("Location: index.php?action=show&id=" . $id);
                exit;
            } else {
                $error = "Erreur lors de la mise à jour du film";
            }
        } else {
            // Pré-remplir avec les données soumises
            $film = array_merge($film, $_POST);
        }
    }

    // Gestion des erreurs de chargement des données
    if ($genres === false) {
        setErrorMessage("Erreur lors du chargement des genres");
        header("Location: index.php?action=index");
        exit;
    }

    include __DIR__ . '/../../templates/films/edit.php';
}

/**
 * Supprime un film
 */
function deleteFilm() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?action=index");
        exit;
    }

    $success = deleteFilmData($id);

    if (!$success) {
        setErrorMessage("Erreur lors de la suppression du film");
    } else {
        setSuccessMessage("Film supprimé avec succès");
    }
    header("Location: index.php?action=index");
    exit;
}

/**
 * Recherche des films
 */
function searchFilms() {
    $search = $_GET['search'] ?? '';
    $films = [];
    $genres = getAllGenres();

    // Récupération des messages depuis la session
    $error = getErrorMessage();
    $success = getSuccessMessage();

    if (!empty($search)) {
        $films = searchFilmsData($search);
        if ($films === false) {
            $error = "Erreur lors de la recherche";
        }
    } else {
        $films = getAllFilms();
        if ($films === false) {
            $error = "Erreur lors du chargement des films";
        }
    }

    include __DIR__ . '/../../templates/films/index.php';
}

/**
 * Valide les données d'un film
 * @param array $data Données à valider
 * @return array Liste des erreurs
 */
function validateFilmData($data) {
    $errors = [];

    if (empty($data['titre'])) {
        $errors['titre'] = "Le titre est obligatoire";
    }

    if (empty($data['realisateur'])) {
        $errors['realisateur'] = "Le réalisateur est obligatoire";
    }

    if (empty($data['annee']) || !is_numeric($data['annee'])) {
        $errors['annee'] = "L'année doit être un nombre";
    } elseif ($data['annee'] < 1800 || $data['annee'] > date('Y') + 5) {
        $errors['annee'] = "L'année doit être entre 1800 et " . (date('Y') + 5);
    }

    if (empty($data['duree']) || !is_numeric($data['duree'])) {
        $errors['duree'] = "La durée doit être un nombre";
    } elseif ($data['duree'] < 1 || $data['duree'] > 600) {
        $errors['duree'] = "La durée doit être entre 1 et 600 minutes";
    }

    if (empty($data['genre_id']) || !is_numeric($data['genre_id'])) {
        $errors['genre_id'] = "Le genre est obligatoire";
    }

    if (!empty($data['note']) && (!is_numeric($data['note']) || $data['note'] < 0 || $data['note'] > 10)) {
        $errors['note'] = "La note doit être entre 0 et 10";
    }

    return $errors;
}
