<?php

namespace App\Services;

use App\Models\UserModel;

class UserService {

    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Inscription
     */
    public function register(string $email, string $username, string $password): array
    {
        // Validation email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Email invalide'];
        }

        // L’email existe déjà
        if ($this->userModel->findByEmail($email)) {
            return ['success' => false, 'error' => 'Email déjà utilisé'];
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Rôle par défaut : Passager
        $this->userModel->create($email, $username, $hashedPassword, "Passager");

        return ['success' => true, 'message' => 'Utilisateur créé'];
    }

    /**
     * Connexion : vérifie mot de passe, renvoie user complet sans passwordHash
     */
    public function login(string $email, string $password): array
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return ['success' => false, 'error' => 'Identifiants invalides'];
        }

        if (!password_verify($password, $user['passwordHash'])) {
            return ['success' => false, 'error' => 'Identifiants invalides'];
        }

        // On enlève le hash avant de renvoyer le user
        unset($user['passwordHash']);

        return [
            'success' => true,
            'user' => $user
        ];
    }
}
