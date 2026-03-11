<?php

namespace App\Tests;

use App\Service\UserSqliteDatabaseFactory;
use PDO;
use PHPUnit\Framework\TestCase;

class UserSqliteDatabaseFactoryTest extends TestCase
{
    public function testCreateForUserCreatesDatabaseFileAndReturnsPdo(): void
    {
        $userId = 12345;
        $factory = new UserSqliteDatabaseFactory();

        $pdo = $factory->createForUser($userId);

        $this->assertInstanceOf(PDO::class, $pdo);

        $baseDir = dirname(__DIR__) . '/var/sqlite/users';
        $dbFile  = $baseDir . '/user_' . $userId . '.db';

        $this->assertFileExists($dbFile);

        // Sanity-Check: Tabelle anlegen und einen Datensatz schreiben/lesen
        $pdo->exec('CREATE TABLE IF NOT EXISTS demo (id INTEGER PRIMARY KEY AUTOINCREMENT, value TEXT NOT NULL)');
        $pdo->exec("INSERT INTO demo (value) VALUES ('user-sqlite-test')");

        $stmt = $pdo->query('SELECT value FROM demo LIMIT 1');
        $row = $stmt->fetch();

        $this->assertSame('user-sqlite-test', $row['value'] ?? null);

        // Aufräumen: die vom Test erstellte Datei wieder löschen
        if (file_exists($dbFile)) {
            unlink($dbFile);
        }
    }
}
