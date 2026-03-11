<?php

namespace App\Database\Migrations;

use App\Database\Connection;
use PDO;
use RuntimeException;

final class MigrationRunner
{
    public function run(): void
    {
        $pdo = Connection::getPdo();

        // Tabelle für angewendete Migrationen sicherstellen
        $this->ensureMigrationsTable($pdo);

        $applied = $this->getAppliedMigrations($pdo);

        $migrationsDir = dirname(__DIR__, 3) . '/migrations';
        if (!is_dir($migrationsDir)) {
            throw new RuntimeException('Migrations-Verzeichnis nicht gefunden: ' . $migrationsDir);
        }

        $files = glob($migrationsDir . '/*.sql');
        sort($files);

        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $applied, true)) {
                // Bereits angewendet, überspringen
                continue;
            }

            $sql = file_get_contents($file);
            if ($sql === false) {
                throw new RuntimeException('Konnte Migration nicht lesen: ' . $file);
            }

            // Einfache Ausführung – wir gehen davon aus, dass jede Datei einen oder wenige Statements enthält
            $pdo->exec($sql);

            $this->markAsApplied($pdo, $name);
        }
    }

    private function ensureMigrationsTable(PDO $pdo): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

        $pdo->exec($sql);
    }

    private function getAppliedMigrations(PDO $pdo): array
    {
        $stmt = $pdo->query('SELECT name FROM migrations ORDER BY id ASC');
        return $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN) : [];
    }

    private function markAsApplied(PDO $pdo, string $name): void
    {
        $stmt = $pdo->prepare('INSERT INTO migrations (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);
    }
}
