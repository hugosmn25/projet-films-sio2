<?php

/**
 * Repository pour la gestion des films
 * Contient toutes les fonctions CRUD pour les films
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Récupère tous les films avec leurs genres
 * @return array|false Liste des films ou false en cas d'erreur
 */
function getAllFilms() {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "SELECT f.*, g.nom as genre_nom 
                FROM films f 
                JOIN genres g ON f.genre_id = g.id 
                ORDER BY f.titre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des films : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère un film par son ID
 * @param int $id ID du film
 * @return array|false Données du film ou false si non trouvé
 */
function getFilmById($id) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "SELECT f.*, g.nom as genre_nom 
                FROM films f 
                JOIN genres g ON f.genre_id = g.id 
                WHERE f.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération du film : " . $e->getMessage());
        return false;
    }
}

/**
 * Ajoute un nouveau film
 * @param array $data Données du film
 * @return int|false ID du film créé ou false en cas d'erreur
 */
function createFilmData($data) {
    // A FAIRE
}

/**
 * Met à jour un film
 * @param int $id ID du film
 * @param array $data Nouvelles données du film
 * @return bool True si succès, false sinon
 */
function updateFilmData($id, $data) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "UPDATE films 
                SET titre = :titre, realisateur = :realisateur, annee = :annee, 
                    duree = :duree, synopsis = :synopsis, genre_id = :genre_id, note = :note 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $data['titre']);
        $stmt->bindParam(':realisateur', $data['realisateur']);
        $stmt->bindParam(':annee', $data['annee'], PDO::PARAM_INT);
        $stmt->bindParam(':duree', $data['duree'], PDO::PARAM_INT);
        $stmt->bindParam(':synopsis', $data['synopsis']);
        $stmt->bindParam(':genre_id', $data['genre_id'], PDO::PARAM_INT);
        $stmt->bindParam(':note', $data['note']);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour du film : " . $e->getMessage());
        return false;
    }
}

/**
 * Supprime un film
 * @param int $id ID du film
 * @return bool True si succès, false sinon
 */
function deleteFilmData($id) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "DELETE FROM films WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression du film : " . $e->getMessage());
        return false;
    }
}

/**
 * Recherche des films par titre ou réalisateur
 * @param string $search Terme de recherche
 * @return array|false Liste des films trouvés ou false en cas d'erreur
 */
function searchFilmsData($search) {
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = "SELECT f.*, g.nom as genre_nom 
                FROM films f 
                JOIN genres g ON f.genre_id = g.id 
                WHERE f.titre LIKE :search1 OR f.realisateur LIKE :search2 
                ORDER BY f.titre";
        $stmt = $pdo->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->bindParam(':search1', $searchTerm);
        $stmt->bindParam(':search2', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erreur lors de la recherche de films : " . $e->getMessage());
        return false;
    }
}
