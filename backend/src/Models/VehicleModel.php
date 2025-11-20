<?php

namespace App\Models;

use PDO;
use App\Database\DBConnection;

class VehicleModel {

    private PDO $pdo;

    public function __construct(DBConnection $db)
    {
        $this->pdo = $db->getPDO();
    }

    /**
     * Crée un véhicule
     */
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO vehicles (
                license_plate,
                marque,
                color,
                model,
                capacity,
                energy_type,
                driver_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['license_plate'],
            $data['marque'],
            $data['color'],
            $data['model'],
            $data['capacity'],
            $data['energy_type'],
            $data['driver_id']
        ]);
    }

    /**
     * Récupère un véhicule via son ID
     */
    public function findById(int $vehicleId): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM vehicles
            WHERE vehicle_id = ?
            LIMIT 1
        ");

        $stmt->execute([$vehicleId]);
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

        return $vehicle ?: null;
    }

    /**
     * Récupère tous les véhicules
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT *
            FROM vehicles
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
