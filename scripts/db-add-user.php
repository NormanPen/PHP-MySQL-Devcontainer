<?php

declare(strict_types=1);

use App\Database\Connection;

require __DIR__ . '/../vendor/autoload.php';

function prompt(string $label): string
{
    $value = '';
    while ($value === '') {
        $value = trim(readline($label));
    }

    return $value;
}

$name  = prompt('Name: ');
$email = prompt('E-Mail: ');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Ungültige E-Mail-Adresse.\n");
    exit(1);
}

$pdo = Connection::getPdo();

$sql = 'INSERT INTO users (name, email) VALUES (:name, :email)';
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'name'  => $name,
    'email' => $email,
]);

$id = (int) $pdo->lastInsertId();

echo "Benutzer wurde gespeichert. ID: {$id}\n";
