<?php

namespace App\Models;

use PDO;
use App\Database\DBConnection;

class RideModel {

    private PDO $pdo;

    public function __construct(DBConnection $db)
    {
        $this->pdo = $db->getPDO();
    }

    /**
     * Crée un nouveau trajet
     */
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO rides (
                price, 
                course_state, 
                date_departure, 
                date_arrival, 
                city_departure, 
                city_arrival, 
                duration, 
                driver_id,
                vehicle_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['price'],
            $data['course_state'],
            $data['date_departure'],
            $data['date_arrival'],
            $data['city_departure'],
            $data['city_arrival'],
            $data['duration'],
            $data['driver_id'],
            $data['vehicle_id']
        ]);
    }

    /**
     * Récupère un trajet via son id
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM rides
            WHERE ride_id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);
        $ride = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ride ?: null;
    }

    /**
     * Récupère tous les trajets (utile pour le futur)
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT *
            FROM rides
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
