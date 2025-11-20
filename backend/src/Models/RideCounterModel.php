<?php

namespace App\Models;

use MongoDB\Client;

class RideCounterModel {

    private $collection;

    public function __construct(Client $mongoClient)
    {
        // Récupération du nom de la base depuis l'environnement
        $dbName = getenv('MONGO_DB') ?: 'ecoride_stats';

        // Sélection BDD + collection
        $this->collection = $mongoClient
            ->selectDatabase($dbName)
            ->selectCollection('stats_rides');
    }

    /**
     * Incrémente le compteur de trajets du jour
     */
    public function incrementToday(): void
    {
        $today = date("Y-m-d");

        $this->collection->updateOne(
            ['date' => $today],
            ['$inc' => ['count' => 1]],
            ['upsert' => true]
        );
    }

    /**
     * Récupère toutes les stats (pour le futur graphique)
     */
    public function getAll(): array
    {
        return $this->collection
            ->find([], ['sort' => ['date' => 1]])
            ->toArray();
    }
}
