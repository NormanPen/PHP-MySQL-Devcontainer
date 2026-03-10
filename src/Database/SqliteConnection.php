<?php

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

final class SqliteConnection
{
    public static function forDatabase(string $name): PDO
    {
        $baseDir = dirname(__DIR__, 2) . '/var/sqlite';

        if (!is_dir($baseDir)) {
            if (!mkdir($baseDir, 0777, true) && !is_dir($baseDir)) {
                throw new RuntimeException(sprintf('Verzeichnis %s konnte nicht erstellt werden.', $baseDir));
            }
        }

        $dbFile = $baseDir . '/' . $name . '.db';

        $dsn = 'sqlite:' . $dbFile;

        try {
            $pdo = new PDO($dsn, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('SQLite-Verbindung fehlgeschlagen: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }

        return $pdo;
    }

    private function __construct()
    {
    }

    private function __clone(): void
    {
    }
}
