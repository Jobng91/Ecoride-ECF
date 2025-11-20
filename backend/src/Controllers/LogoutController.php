<?php

namespace App\Controllers;

use App\Services\AuthService;

class LogoutController
{
    private AuthService $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function logout()
    {
        $user = $this->auth->getAuthenticatedUser();
        if ($user) {
            $this->auth->clearToken($user['user_id']);
        }

        setcookie('auth_token', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'httponly' => true,
            'secure'   => false,
            'samesite' => 'Lax',
        ]);

        echo json_encode(['success' => true]);
    }
}
