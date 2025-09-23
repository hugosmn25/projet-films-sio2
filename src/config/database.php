<?php

/**
 * Configuration de la base de données
 * Fichier de configuration pour la connexion à la base de données MySQL
 */

// Configuration de la base de données
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'db_films');
define('DB_USER', 'user');
define('DB_PASS', 'secret');
define('DB_PORT', '3330');

/**
 * Établit une connexion à la base de données
 * @return PDO|false Retourne l'objet PDO ou false en cas d'erreur
 */
function getDatabaseConnection() {
    try {
        // Forcer la connexion TCP/IP même avec localhost
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erreur de connexion à la base de données : " . $e->getMessage());
        return false;
    }
}
