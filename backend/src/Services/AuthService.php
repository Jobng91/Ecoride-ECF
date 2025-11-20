<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService {

    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getAuthenticatedUser(): ?array
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) {
            return null;
        }

        $user = $this->userModel->findByToken($token);
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function setToken(int $userId, string $token): bool
    {
        return $this->userModel->updateToken($userId, $token);
    }

    public function clearToken(int $userId): bool
    {
        return $this->userModel->updateToken($userId, null);
    }

}
