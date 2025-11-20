<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController {

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register
     */
    public function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $email = $data['email'] ?? '';
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $result = $this->userService->register($email, $username, $password);

        echo json_encode($result);
    }

    /**
     * Login (NE gère PAS le token)
     */
    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $result = $this->userService->login($email, $password);

        echo json_encode($result);
    }
}
