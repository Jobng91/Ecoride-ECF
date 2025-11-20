<?php

namespace App\Controllers;

use App\Services\VehicleService;

class VehicleController {

    private VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * Créer un véhicule
     */
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $result = $this->vehicleService->create($data);

        echo json_encode($result);
    }

    /**
     * Obtenir un véhicule via ID
     */
    public function get()
    {
        $vehicleId = $_GET['id'] ?? null;

        if (!$vehicleId) {
            echo json_encode(['success' => false, 'error' => 'ID requis']);
            return;
        }

        $result = $this->vehicleService->get((int) $vehicleId);

        echo json_encode($result);
    }

    /**
     * Obtenir tous les véhicules
     */
    public function getAll()
    {
        $result = $this->vehicleService->getAll();

        echo json_encode($result);
    }
}
