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

// Einfache Routing-Logik auf Basis der Request-URI, z.B. /, /about, /exercises, /exercises/1
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

// Trailing Slash entfernen, aber Root "/" beibehalten
if ($uri !== '/') {
	$uri = rtrim($uri, '/');
}

// Standardwerte
$view = 'pages/home.php';
$data = [
	'title' => 'Startseite',
	'page' => 'home',
];

if ($uri === '/') {
	// Startseite
	$view = 'pages/home.php';
	$data = [
		'title' => 'Startseite',
		'page' => 'home',
	];
} elseif ($uri === '/about') {
	// Über-Seite
	$view = 'pages/about.php';
	$data = [
		'title' => 'Über',
		'page' => 'about',
	];
} elseif ($uri === '/exercises') {
	// Übungen-Übersicht
	$view = 'pages/exercise.php';
	$data = [
		'title' => 'Übungen',
		'page' => 'exercises',
		'exercise' => null,
	];
} elseif (str_starts_with($uri, '/exercises/')) {
	// Einzelne Übung, z.B. /exercises/1 oder /exercises/2
	$exercise = null;
	$exerciseSlug = substr($uri, strlen('/exercises/'));

	switch ($exerciseSlug) {
		case '1':
			$view = 'pages/exercises/exercise1.php';
			$exercise = '1';
			break;
		case '2':
			$view = 'pages/exercises/exercise2.php';
			$exercise = '2';
			break;
		default:
			// Unbekannte Übung → zurück zur Übersicht
			$view = 'pages/exercise.php';
			break;
	}

	$data = [
		'title' => 'Übungen',
		'page' => 'exercises',
		'exercise' => $exercise,
	];
// ...existing code...
} elseif ($uri === '/account') {
	// Account-Seite nur für eingeloggte Benutzer
	if (empty($_SESSION['user'])) {
		header('Location: /login');
		exit;
	}

	$view = 'pages/account.php';
	$data = [
		'title' => 'Dein Account',
		'page' => 'account',
		'user' => $_SESSION['user'],
	];
} elseif ($uri === '/logout') {
	// Einfache Logout-Route
	$_SESSION = [];
	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
	}
	session_destroy();
	header('Location: /');
	exit;
} elseif ($uri === '/login') {
	// Login & Registrierung
	$pdo = Connection::getPdo();
	$error = null;

	if (!empty($_SESSION['user'])) {
		header('Location: /account');
		exit;
	}

	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
		require_once __DIR__ . '/../src/Service/UserService.php';
		$service = new App\Service\UserService($pdo);

		// Registrierung
		if (isset($_POST['register'])) {
			$name = trim((string)($_POST['reg_name'] ?? ''));
			$email = trim((string)($_POST['reg_email'] ?? ''));
			$password = (string)($_POST['reg_password'] ?? '');
			$result = $service->registerUser($name, $email, $password);
			if (isset($result['error'])) {
				$error = $result['error'];
			} else {
				$_SESSION['user'] = $result;
				header('Location: /account');
				exit;
			}
		}
		// Login
		if (isset($_POST['login'])) {
			$email = trim((string)($_POST['email'] ?? ''));
			$password = (string)($_POST['password'] ?? '');
			$result = $service->loginUser($email, $password);
			if (isset($result['error'])) {
				$error = $result['error'];
			} else {
				$_SESSION['user'] = $result;
				header('Location: /account');
				exit;
			}
		}
	}

	$view = 'pages/login.php';
	$data = [
		'title' => 'Login',
		'page' => 'login',
		'error' => $error,
	];
}
// Layout (base.php) einbinden und View + Daten übergeben
// base.php kümmert sich darum, header.php, die View und footer.php zu laden
// und die Variablen aus $data verfügbar zu machen.

// Wichtig: $view und $data als Variablen definieren, bevor base.php inkludiert wird
require __DIR__ . '/../views/base.php';