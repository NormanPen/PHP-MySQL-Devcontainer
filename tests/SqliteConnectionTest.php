<?php

namespace App\Tests;

use App\Database\SqliteConnection;
use PDO;
use PHPUnit\Framework\TestCase;

class SqliteConnectionTest extends TestCase
{
    public function testForDatabaseReturnsPdoAndCanCreateTable(): void
    {
        $pdo = SqliteConnection::forDatabase('test');

        $this->assertInstanceOf(PDO::class, $pdo);

        $pdo->exec('CREATE TABLE IF NOT EXISTS demo (id INTEGER PRIMARY KEY AUTOINCREMENT, value TEXT NOT NULL)');
        $pdo->exec("INSERT INTO demo (value) VALUES ('hello sqlite')");

        $stmt = $pdo->query('SELECT value FROM demo LIMIT 1');
        $row = $stmt->fetch();

        $this->assertSame('hello sqlite', $row['value'] ?? null);
    }
}
