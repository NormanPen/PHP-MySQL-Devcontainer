<?php

namespace App\Tests;

use App\Database\Connection;
use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testGetPdoReturnsPdoInstance(): void
    {
        $pdo = Connection::getPdo();

        $this->assertInstanceOf(PDO::class, $pdo);
    }
}
