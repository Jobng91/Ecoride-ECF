<?php

namespace App\Controllers;

use App\Services\AuthService;

class MeController {

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Retourne l'utilisateur actuellement connecté via le cookie HttpOnly.
     */
    public function show()
    {
        header('Content-Type: application/json');

        $user = $this->authService->getAuthenticatedUser();

        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Not authenticated'
            ]);
            return;
        }

        // Conversion du rôle SQL → format ROLE_XXX utilisé dans le front SPA
        $user['role'] = $this->convertRole($user['user_role']);
        unset($user['user_role']); // Le front ne doit pas recevoir ce champ

        echo json_encode([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Convertit les rôles SQL ('Passager', 'Chauffeur', 'Employé', 'Admin')
     * en rôles utilisés dans le front ('ROLE_PASSAGER', etc.).
     */
    private function convertRole(string $dbRole): string
    {
        return match ($dbRole) {
            'Passager' => 'ROLE_PASSAGER',
            'Chauffeur' => 'ROLE_CHAUFFEUR',
            'Employé'  => 'ROLE_EMPLOYE',
            'Admin'    => 'ROLE_ADMIN',
            default    => 'ROLE_PASSAGER',
        };
    }
}
