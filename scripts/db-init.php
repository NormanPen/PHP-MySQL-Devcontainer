<?php

declare(strict_types=1);

use App\Database\Connection;

require __DIR__ . '/../vendor/autoload.php';

echo "Verbinde zur Datenbank...\n";

$pdo = Connection::getPdo();

echo "Verbindung OK.\n";

// Beispiel: einfache users-Tabelle anlegen
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

$pdo->exec($sql);

echo "Tabelle users (falls nicht vorhanden) wurde angelegt.\n";

// vorhandene Tabellen ausgeben
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

echo "Aktuelle Tabellen in der Datenbank:" . PHP_EOL;
foreach ($tables as $table) {
    echo " - {$table}" . PHP_EOL;
}
