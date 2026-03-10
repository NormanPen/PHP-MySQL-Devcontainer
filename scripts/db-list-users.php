<?php

declare(strict_types=1);

use App\Database\Connection;

require __DIR__ . '/../vendor/autoload.php';

$pdo = Connection::getPdo();

$stmt = $pdo->query('SELECT id, name, email, created_at FROM users ORDER BY id ASC');
$users = $stmt->fetchAll();

if (!$users) {
    echo "Keine Benutzer in der Tabelle users gefunden." . PHP_EOL;
    exit(0);
}

echo "Benutzer in users:" . PHP_EOL;
foreach ($users as $user) {
    echo sprintf(
        " - [%d] %s <%s> (erstellt: %s)\n",
        (int) $user['id'],
        $user['name'],
        $user['email'],
        $user['created_at'] ?? '-'
    );
}
