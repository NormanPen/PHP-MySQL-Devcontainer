<?php

namespace App\Service;

use App\Database\Connection;
use PDO;
use Exception;

class PasswordResetService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Connection::getPdo();
    }

    public function createResetToken(string $email): ?string
    {
        // Nutzer-ID zur E-Mail suchen
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!$user) {
            return null;
        }
        $userId = $user['id'];
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 3600); // 1 Stunde gültig

        // Token speichern
        $stmt = $this->pdo->prepare('INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $token, $expires]);
        return $token;
    }
}
