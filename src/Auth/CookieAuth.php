<?php

namespace App\Auth;

class CookieAuth
{
    public static function setAuthCookie(string $token): void
    {
        setcookie('auth_token', $token, [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    public static function getAuthCookie(): ?string
    {
        return $_COOKIE['auth_token'] ?? null;
    }

    public static function deleteAuthCookie(): void
    {
        setcookie('auth_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
