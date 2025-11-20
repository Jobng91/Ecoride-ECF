<?php

namespace App\Middleware;

use App\Services\AuthService;

class AuthMiddleware {

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

  
    public function requireAuth(): array
    {
        $user = $this->authService->getAuthenticatedUser();

        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Not authenticated'
            ]);
            exit();
        }

        return $user;
    }

  
    public function requireRole(array $roles): array
    {
        $user = $this->requireAuth(); // vérifie aussi 401

        // Convertit user_role de la BDD en rôle SPA
        $role = match ($user['user_role']) {
            'Admin' => 'ROLE_ADMIN',
            'Chauffeur' => 'ROLE_CHAUFFEUR',
            'Passager' => 'ROLE_PASSAGER',
            'Employé' => 'ROLE_EMPLOYE',
            default => 'ROLE_PASSAGER'
        };

        if (!in_array($role, $roles)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'error' => 'Forbidden: insufficient role'
            ]);
            exit();
        }

        return $user;
    }
}
