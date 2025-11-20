<?php

namespace App\Database;

use MongoDB\Client;

class MongoDBConnection {

    private Client $client;

    public function __construct()
    {
        $host = getenv('MONGO_HOST') ?: 'mongo';
        $port = getenv('MONGO_PORT') ?: '27017';
        $user = getenv('MONGO_USER');
        $pass = getenv('MONGO_PASSWORD');

        // IMPORTANT : l'utilisateur Mongo est créé dans la DB 'admin'
        $authDb = 'admin';

        $uri = "mongodb://{$user}:{$pass}@{$host}:{$port}/?authSource={$authDb}";

        // Exemple final : mongodb://jobng:root@mongo:27017/?authSource=admin
        $this->client = new Client($uri);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
