<?php

namespace App\Service;

use App\Database\SqliteConnection;
use PDO;

/**
 * Einfacher Helfer, um pro Nutzer eine eigene SQLite-Datenbank zu erzeugen.
 *
 * Die Datei wird unter var/sqlite/users/user_<id>.db angelegt.
 * Später kannst du die MySQL-User-ID direkt als Parameter durchreichen.
 */
final class UserSqliteDatabaseFactory
{
    public function createForUser(int $userId): PDO
    {
        // Unterordner "users" sicherstellen
        $baseDir   = dirname(__DIR__, 2) . '/var/sqlite/users';
        if (!is_dir($baseDir)) {
            if (!mkdir($baseDir, 0777, true) && !is_dir($baseDir)) {
                throw new \RuntimeException(sprintf('Verzeichnis %s konnte nicht erstellt werden.', $baseDir));
            }
        }

        // Wir nutzen SqliteConnection weiter und kodieren den Pfadanteil "users/" im Namen
        $dbName = 'users/user_' . $userId;

        return SqliteConnection::forDatabase($dbName);
    }
}
