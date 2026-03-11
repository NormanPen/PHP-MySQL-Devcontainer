<?php

declare(strict_types=1);

use App\Service\UserSqliteDatabaseFactory;

require __DIR__ . '/../vendor/autoload.php';

if ($argc < 2) {
    fwrite(STDERR, "Verwendung: php scripts/create-user-sqlite.php <userId>\n");
    exit(1);
}

$userId = filter_var($argv[1], FILTER_VALIDATE_INT);

if ($userId === false || $userId <= 0) {
    fwrite(STDERR, "Ungültige User-ID: {$argv[1]}\n");
    exit(1);
}

$factory = new UserSqliteDatabaseFactory();
$pdo = $factory->createForUser($userId);

$baseDir = dirname(__DIR__) . '/var/sqlite/users';
$dbFile  = $baseDir . '/user_' . $userId . '.db';

// Kleine Demo-Initialisierung, damit die DB nicht komplett leer ist
$pdo->exec('CREATE TABLE IF NOT EXISTS user_meta (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, created_at TEXT NOT NULL)');
$stmt = $pdo->prepare('INSERT INTO user_meta (user_id, created_at) VALUES (:user_id, :created_at)');
$stmt->execute([
    'user_id'    => $userId,
    'created_at' => (new DateTimeImmutable())->format('c'),
]);

echo "SQLite-Datenbank für User {$userId} erstellt/geöffnet: {$dbFile}\n";
echo "Es wurde ein Eintrag in der Tabelle user_meta angelegt.\n";
