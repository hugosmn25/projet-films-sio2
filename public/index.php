<?php

/**
 * Front Controller - Point d'entrée de l'application
 * Route les requêtes vers les bons contrôleurs
 */

// Configuration des erreurs pour le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session pour les messages
session_start();

// Inclusion du contrôleur des films
require_once __DIR__ . '/../src/controllers/filmController.php';

// Récupération de l'action demandée
$action = $_GET['action'] ?? 'index';

// Routage des actions - les contrôleurs gèrent leurs propres paramètres
switch ($action) {
    case 'index':
        indexFilms();
        break;

    case 'show':
        showFilm();
        break;

    case 'create':
        createFilm();
        break;

    case 'edit':
        editFilm();
        break;

    case 'delete':
        deleteFilm();
        break;

    case 'search':
        searchFilms();
        break;

    default:
        // Action non reconnue, redirection vers l'index
        header("Location: index.php?action=index");
        exit;
}
