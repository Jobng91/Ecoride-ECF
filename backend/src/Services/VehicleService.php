<?php

namespace App\Services;

use App\Models\VehicleModel;

class VehicleService {

    private VehicleModel $vehicleModel;

    public function __construct(VehicleModel $vehicleModel)
    {
        $this->vehicleModel = $vehicleModel;
    }

    /**
     * Création d'un véhicule
     */
    public function create(array $vehicleData): array
    {
        // Validation simple
        if (empty($vehicleData['license_plate']) ||
            empty($vehicleData['marque']) ||
            empty($vehicleData['model']) ||
            empty($vehicleData['capacity']) ||
            empty($vehicleData['energy_type']) ||
            empty($vehicleData['driver_id']))
        {
            return ['success' => false, 'error' => 'Champs obligatoires manquants'];
        }

        $this->vehicleModel->create($vehicleData);

        return ['success' => true, 'message' => 'Véhicule créé'];
    }

    /**
     * Récupère un véhicule
     */
    public function get(int $vehicleId): array
    {
        $vehicle = $this->vehicleModel->findById($vehicleId);

        if (!$vehicle) {
            return ['success' => false, 'error' => 'Véhicule introuvable'];
        }

        return ['success' => true, 'vehicle' => $vehicle];
    }

    /**
     * Récupère tous les véhicules
     */
    public function getAll(): array
    {
        return [
            'success' => true,
            'vehicles' => $this->vehicleModel->findAll()
        ];
    }
}
