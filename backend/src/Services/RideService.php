<?php

namespace App\Services;

use App\Models\RideModel;
use App\Models\RideCounterModel;

class RideService {

    private RideModel $rideModel;
    private RideCounterModel $counter;

    public function __construct(RideModel $rideModel, RideCounterModel $counter)
    {
        $this->rideModel = $rideModel;
        $this->counter = $counter;
    }

    /**
     * Création d'un trajet
     */
    public function create(array $rideData): array
    {
        // --- Validations ---
        if (empty($rideData['price']) ||
            empty($rideData['course_state']) ||
            empty($rideData['date_departure']) ||
            empty($rideData['city_departure']) ||
            empty($rideData['city_arrival']) ||
            empty($rideData['driver_id']) ||
            empty($rideData['vehicle_id'])) 
        {
            return ['success' => false, 'error' => 'Champs obligatoires manquants'];
        }

        // --- Création SQL ---
        $success = $this->rideModel->create($rideData);

        if (!$success) {
            return ['success' => false, 'error' => 'Erreur SQL lors de la création'];
        }

        // --- Incrément MongoDB ---
        try {
            $this->counter->incrementToday();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Créé en SQL mais erreur MongoDB : ' . $e->getMessage()
            ];
        }

        return ['success' => true, 'message' => 'Trajet créé + compteur mis à jour'];
    }

    /**
     * Récupère un trajet
     */
    public function get(int $rideId): array
    {
        $ride = $this->rideModel->findById($rideId);

        if (!$ride) {
            return ['success' => false, 'error' => 'Trajet introuvable'];
        }

        return ['success' => true, 'ride' => $ride];
    }

    /**
     * Récupère tous les trajets SQL
     */
    public function getAll(): array
    {
        return [
            'success' => true,
            'rides' => $this->rideModel->findAll()
        ];
    }

    /**
     * Récupère les stats MongoDB (count par jour)
     */
    public function getStats(): array
    {
        try {
            $stats = $this->counter->getAll();

            return [
                'success' => true,
                'stats' => $stats
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Erreur MongoDB : ' . $e->getMessage()
            ];
        }
    }
}

