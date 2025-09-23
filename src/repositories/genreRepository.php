<?php

/**
 * Repository pour la gestion des genres
 * Contient toutes les fonctions CRUD pour les genres
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Récupère tous les genres
 * @return array|false Liste des genres ou false en cas d'erreur
 */
function getAllGenres() {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "SELECT * FROM genres ORDER BY nom";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des genres : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère un genre par son ID
 * @param int $id ID du genre
 * @return array|false Données du genre ou false si non trouvé
 */
function getGenreById($id) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "SELECT * FROM genres WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération du genre : " . $e->getMessage());
        return false;
    }
}

/**
 * Ajoute un nouveau genre
 * @param array $data Données du genre
 * @return int|false ID du genre créé ou false en cas d'erreur
 */
function createGenreData($data) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "INSERT INTO genres (nom, description) VALUES (:nom, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->execute();
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Erreur lors de la création du genre : " . $e->getMessage());
        return false;
    }
}

/**
 * Met à jour un genre
 * @param int $id ID du genre
 * @param array $data Nouvelles données du genre
 * @return bool True si succès, false sinon
 */
function updateGenreData($id, $data) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "UPDATE genres SET nom = :nom, description = :description WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':description', $data['description']);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour du genre : " . $e->getMessage());
        return false;
    }
}

/**
 * Supprime un genre
 * @param int $id ID du genre
 * @return bool True si succès, false sinon
 */
function deleteGenreData($id) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "DELETE FROM genres WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression du genre : " . $e->getMessage());
        return false;
    }
}

/**
 * Recherche des genres par nom
 * @param string $search Terme de recherche
 * @return array|false Liste des genres trouvés ou false en cas d'erreur
 */
function searchGenresData($search) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "SELECT * FROM genres WHERE nom LIKE :search ORDER BY nom";
        $stmt = $pdo->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erreur lors de la recherche de genres : " . $e->getMessage());
        return false;
    }
}
