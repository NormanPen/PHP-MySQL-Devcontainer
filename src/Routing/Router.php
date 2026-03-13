<?php

// Einfache Router-Klasse für statische und dynamische Seiten

use App\Database\Connection;

class Router
{
    private array $routes = [];
    private $notFound;
    public $match = null;

    public function get(string $path, callable $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function setNotFound(callable $handler)
    {
        $this->notFound = $handler;
    }

    public function dispatch(string $method, string $uri, &$view, &$data)
    {
        // Routen-Registrierung (ausgelagert aus index.php)
        $this->registerRoutes($view, $data);
        $uri = rtrim($uri, '/');
        if ($uri === '') $uri = '/';
        if (isset($this->routes[$method][$uri])) {
            return call_user_func($this->routes[$method][$uri]);
        }
        if ($this->notFound) {
            return call_user_func($this->notFound);
        }
        http_response_code(404);
        echo '404 Not Found';
        exit;
    }

    private function registerRoutes(&$view, &$data)
    {
        $this->get('/', function() use (&$view, &$data) {
            $view = 'pages/home.php';
            $data = [ 'title' => 'Startseite', 'page' => 'home' ];
        });
        $this->get('/about', function() use (&$view, &$data) {
            $view = 'pages/about.php';
            $data = [ 'title' => 'Über', 'page' => 'about' ];
        });
        $this->get('/impressum', function() use (&$view, &$data) {
            $view = 'pages/impressum.php';
            $data = [ 'title' => 'Impressum', 'page' => 'impressum' ];
        });
        $this->get('/datenschutz', function() use (&$view, &$data) {
            $view = 'pages/datenschutz.php';
            $data = [ 'title' => 'Datenschutz', 'page' => 'datenschutz' ];
        });
        $this->get('/exercises', function() use (&$view, &$data) {
            $view = 'pages/exercise.php';
            $data = [ 'title' => 'Übungen', 'page' => 'exercises', 'exercise' => null ];
        });
        $this->get('/exercises/1', function() use (&$view, &$data) {
            $view = 'pages/exercises/exercise1.php';
            $data = [ 'title' => 'Übungen', 'page' => 'exercises', 'exercise' => '1' ];
        });
        $this->get('/exercises/2', function() use (&$view, &$data) {
            $view = 'pages/exercises/exercise2.php';
            $data = [ 'title' => 'Übungen', 'page' => 'exercises', 'exercise' => '2' ];
        });
        $this->get('/account', function() use (&$view, &$data) {
            if (empty($_SESSION['user'])) {
                header('Location: /login');
                exit;
            }
            $view = 'pages/account.php';
            $data = [ 'title' => 'Dein Account', 'page' => 'account', 'user' => $_SESSION['user'] ];
        });
        $this->get('/logout', function() {
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            }
            session_destroy();
            header('Location: /');
            exit;
        });
        $this->get('/sign-up', function() use (&$view, &$data) {
            $view = 'pages/sign-up.php';
            $data = [ 'title' => 'Registrieren', 'page' => 'sign-up' ];
        });
        $loginHandler = function() use (&$view, &$data) {
            $pdo = Connection::getPdo();
            $error = null;
            if (!empty($_SESSION['user'])) {
                header('Location: /');
                exit;
            }
            if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
                require_once __DIR__ . '/../../src/Service/UserService.php';
                $service = new \App\Service\UserService($pdo);
                if (isset($_POST['register'])) {
                    $firstname = trim((string)($_POST['reg_firstname'] ?? ''));
                    $lastname = trim((string)($_POST['reg_lastname'] ?? ''));
                    $email = trim((string)($_POST['reg_email'] ?? ''));
                    $password = (string)($_POST['reg_password'] ?? '');
                    $result = $service->registerUser($firstname, $lastname, $email, $password);
                    if (isset($result['error'])) {
                        $error = $result['error'];
                    } else {
                        $_SESSION['user'] = $result;
                        header('Location: /');
                        exit;
                    }
                }
                if (isset($_POST['login'])) {
                    $email = trim((string)($_POST['email'] ?? ''));
                    $password = (string)($_POST['password'] ?? '');
                    $result = $service->loginUser($email, $password);
                    if (isset($result['error'])) {
                        $error = $result['error'];
                    } else {
                        $_SESSION['user'] = $result;
                        header('Location: /');
                        exit;
                    }
                }
            }
            $view = 'pages/sign-in.php';
            $data = [ 'title' => 'Login', 'page' => 'login', 'error' => $error ];
        };
        $this->get('/login', $loginHandler);
        $this->post('/login', $loginHandler);
        $this->setNotFound(function() use (&$view, &$data) {
            http_response_code(404);
            $view = 'pages/404.php';
            $data = [ 'title' => 'Seite nicht gefunden', 'page' => '404' ];
        });
    }
}
