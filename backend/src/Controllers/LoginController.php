<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Services\AuthService;

class LoginController {

    private UserService $userService;
    private AuthService $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Service login (valide email/pass)
        $loginResult = $this->userService->login($email, $password);

        if (!$loginResult['success']) {
            echo json_encode($loginResult);
            return;
        }

        $userId = $loginResult['user']['user_id'];

        // Génération token
        $token = bin2hex(random_bytes(32));

        // Stockage token en BDD
        $this->authService->setToken($userId, $token);


        // Cookie HttpOnly
        setcookie(
            "auth_token",
            $token,
            [
                "expires" => time() + 86400 * 7,
                "path" => "/",
                "secure" => true,
                "httponly" => true,
                "samesite" => "Strict"
            ]
        );

        echo json_encode([
            "success" => true,
            "message" => "Connexion réussie"
        ]);
    }
}
