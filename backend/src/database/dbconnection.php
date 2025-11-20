<?php

namespace App\Database;

use PDO;

class DBConnection {

    private PDO $pdo;

    public function __construct()
    {
        $dbname = getenv('DB_NAME');
        $host = getenv('DB_HOST');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        $this->pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
