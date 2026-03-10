<?php

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

final class Connection
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host    = getenv('DB_HOST') ?: 'db';
        $port    = getenv('DB_PORT') ?: '3306';
        $dbName  = getenv('DB_DATABASE') ?: 'app';
        $user    = getenv('DB_USERNAME') ?: 'app';
        $pass    = getenv('DB_PASSWORD') ?: 'app';
        $charset = 'utf8mb4';

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $dbName, $charset);

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Datenbankverbindung fehlgeschlagen: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }

        self::$pdo = $pdo;

        return $pdo;
    }

    private function __construct()
    {
    }

    private function __clone(): void
    {
    }
}
