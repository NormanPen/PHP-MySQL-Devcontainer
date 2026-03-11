<?php

declare(strict_types=1);

use App\Database\Migrations\MigrationRunner;

require __DIR__ . '/../vendor/autoload.php';

echo "Starte Datenbank-Migrationen...\n";

$runner = new MigrationRunner();
$runner->run();

echo "Migrationen abgeschlossen.\n";
