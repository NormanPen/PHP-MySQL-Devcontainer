<?php

namespace App\Service;

use App\Database\Connection;
use PDO;
use PDOException;

class UserService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Connection::getPdo();
    }

    /**
     * Registriert einen neuen Nutzer.
     * Gibt ein Array mit Userdaten zurück oder einen Fehlerstring.
     */
    public function registerUser(string $firstname, string $lastname, string $email, string $password): array
    {
        if ($firstname === '' || $lastname === '') {
            return ['error' => 'Bitte gib Vor- und Nachnamen an.'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Ungültige E-Mail-Adresse.'];
        }
        if (strlen($password) < 6) {
            return ['error' => 'Das Passwort muss mindestens 6 Zeichen lang sein.'];
        }

        // Prüfen, ob E-Mail schon existiert
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['error' => 'Diese E-Mail ist bereits registriert.'];
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $this->pdo->prepare('INSERT INTO users (email, password_hash, firstname, lastname, created_at) VALUES (?, ?, ?, ?, NOW())');
            $stmt->execute([$email, $hash, $firstname, $lastname]);
            $id = $this->pdo->lastInsertId();
            return [
                'id'        => $id,
                'email'     => $email,
                'firstname' => $firstname,
                'lastname'  => $lastname,
            ];
        } catch (PDOException $e) {
            return ['error' => 'Fehler beim Speichern: ' . $e->getMessage()];
        }
    }

    /**
     * Prüft Login und gibt Userdaten oder Fehler zurück.
     */
    public function loginUser(string $email, string $password): array
    {
        $stmt = $this->pdo->prepare('SELECT id, email, password_hash, firstname, lastname FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            // Auth-Token erzeugen und im Cookie setzen
            $authService = new \App\Auth\AuthService($this->pdo);
            $cookieAuth = new \App\Auth\CookieAuth();
            $token = $authService->createToken((int)$user['id']);
            $cookieAuth::setAuthCookie($token);
            return [
                'id'        => $user['id'],
                'email'     => $user['email'],
                'firstname' => $user['firstname'] ?? '',
                'lastname'  => $user['lastname'] ?? '',
            ];
        }
        return ['error' => 'Login fehlgeschlagen. Bitte prüfe deine Zugangsdaten.'];
    }
}
