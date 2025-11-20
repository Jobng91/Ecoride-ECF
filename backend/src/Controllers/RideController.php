<?php

namespace App\Controllers;

use App\Services\RideService;

class RideController {

    private RideService $rideService;

    public function __construct(RideService $rideService)
    {
        $this->rideService = $rideService;
    }

    /**
     * Créer un trajet
     */
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $result = $this->rideService->create($data);

        echo json_encode($result);
    }

    /**
     * Obtenir un trajet via SQL
     */
    public function get()
    {
        $rideId = $_GET['id'] ?? null;

        if (!$rideId) {
            echo json_encode(['success' => false, 'error' => 'ID requis']);
            return;
        }

        $result = $this->rideService->get((int) $rideId);

        echo json_encode($result);
    }

    /**
     * Obtenir tous les trajets SQL
     */
    public function getAll()
    {
        $result = $this->rideService->getAll();

        echo json_encode($result);
    }

    /**
     * Obtenir les stats MongoDB (compteur par jour)
     */
    public function getStats()
    {
        $result = $this->rideService->getStats();

        echo json_encode($result);
    }
}

