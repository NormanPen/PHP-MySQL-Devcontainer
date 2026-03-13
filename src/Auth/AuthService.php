<?php

namespace App\Auth;

use App\Database\Connection;
use PDO;

class AuthService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Connection::getPdo();
    }

    /**
     * Prüft einen Auth-Token aus Cookie und gibt Userdaten zurück oder null.
     */
    public function authenticateByToken(?string $token): ?array
    {
        if (!$token) return null;
        $stmt = $this->pdo->prepare('SELECT u.id, u.email, u.name FROM users u JOIN user_tokens t ON t.user_id = u.id WHERE t.token = ? AND t.expires_at > NOW()');
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Generiert und speichert einen neuen Auth-Token für einen User.
     */
    public function createToken(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
        $stmt = $this->pdo->prepare('INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $token, $expires]);
        return $token;
    }

    /**
     * Löscht einen Token (z.B. beim Logout).
     */
    public function deleteToken(string $token): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM user_tokens WHERE token = ?');
        $stmt->execute([$token]);
    }
}
