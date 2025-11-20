<?php

namespace App\Models;

use PDO;
use App\Database\DBConnection;

class UserModel {

    private PDO $pdo;

    public function __construct(DBConnection $db)
    {
        $this->pdo = $db->getPDO();
    }

    /**
     * Récupère un utilisateur via son email
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                user_id,
                email,
                username,
                user_role,
                picture,
                credit,
                passwordHash,
                created_at,
                updated_at
            FROM users 
            WHERE email = ?
            LIMIT 1
        ");
        
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Crée un utilisateur
     */
    public function create(string $email, string $username, string $hashedPassword, string $role = "Passager"): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (email, username, passwordHash, user_role) 
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([$email, $username, $hashedPassword, $role]);
    }

    /**
     * Mets à jour le token d'auth de l'utilisateur
     */
    public function updateToken(int $userId, ?string $token): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET auth_token = ?
            WHERE user_id = ?
        ");

        return $stmt->execute([$token, $userId]);
    }

    /**
     * Trouve un utilisateur via un token d'auth
     */
    public function findByToken(string $token): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                user_id,
                email,
                username,
                user_role,
                picture,
                credit,
                created_at,
                updated_at
            FROM users 
            WHERE auth_token = ?
            LIMIT 1
        ");
        
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Récupère un utilisateur via son ID 
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                user_id,
                email,
                username,
                user_role,
                picture,
                credit,
                created_at,
                updated_at
            FROM users 
            WHERE user_id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
