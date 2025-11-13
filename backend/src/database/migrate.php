<?php

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');


$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
$user = $user;
$password = $pass;

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à MySQL.\n";

    // Création d'une table interne pour suivre les migrations exécutées
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations_executed (
            id INT AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $files = glob(__DIR__ . '/migrations/*.sql');
    sort($files);

    foreach ($files as $file) {
        $filename = basename($file);

        // Vérifie si la migration a déjà été exécutée
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations_executed WHERE filename = ?");
        $stmt->execute([$filename]);
        if ($stmt->fetchColumn() > 0) {
            echo "⏭  Migration déjà exécutée : $filename\n";
            continue;
        }

        // Exécute le SQL
        $sql = file_get_contents($file);
        $pdo->exec($sql);

        // Marque la migration comme exécutée
        $stmt = $pdo->prepare("INSERT INTO migrations_executed (filename) VALUES (?)");
        $stmt->execute([$filename]);

        echo "✔ Migration appliquée : $filename\n";
    }

    echo "\nToutes les migrations sont à jour.\n";

} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}