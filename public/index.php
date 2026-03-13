<?php

declare(strict_types=1);

// Composer Autoloader laden (falls du später Controller/Services in src/ nutzt)
require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;

// Session für einfache Login-Logik starten
session_start();

// Nur zum Testen: Demo-User immer eingeloggt
// Hinweis: Später wieder entfernen, wenn der echte Login verwendet wird.
// $_SESSION['user'] = ['name' => 'Demo-User'];



require_once __DIR__ . '/../src/Routing/Router.php';
$view = '';
$data = [];
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$router = new Router();
$router->dispatch($_SERVER['REQUEST_METHOD'], $uri, $view, $data);

require __DIR__ . '/../views/base.php';