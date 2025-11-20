<?php

namespace App\Controllers;

use App\Services\AuthService;

class MeController {

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function show()
    {
        $user = $this->authService->getAuthenticatedUser();

        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Not authenticated'
            ]);
            return;
        }

        // Conversion du rôle SQL vers format front
        $user['role'] = $this->convertRole($user['user_role']);
        unset($user['user_role']); // On garde seulement la version "ROLE_XYZ"

        echo json_encode([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Convertit les rôles SQL ('Passager', 'Admin', etc.)
     * vers les rôles front utilisés dans ton routeur ('ROLE_PASSAGER', etc.).
     */
    private function convertRole(string $dbRole): string
    {
        return match ($dbRole) {
            'Passager' => 'ROLE_PASSAGER',
            'Chauffeur' => 'ROLE_CHAUFFEUR',
            'Employé'  => 'ROLE_EMPLOYE',
            'Admin'    => 'ROLE_ADMIN',
            default    => 'ROLE_PASSAGER'
        };
    }
}
