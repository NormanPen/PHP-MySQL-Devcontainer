<?php

declare(strict_types=1);

use App\Database\Connection;

require __DIR__ . '/../vendor/autoload.php';

$pdo = Connection::getPdo();

$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

if (!$tables) {
    echo "Keine Tabellen in der Datenbank gefunden." . PHP_EOL;
    exit(0);
}

echo "Tabellen in der Datenbank:" . PHP_EOL;
foreach ($tables as $table) {
    echo " - {$table}" . PHP_EOL;
}
