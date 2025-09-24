<?php

namespace App\Helpers;

class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verify(string $token): bool
    {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    public static function inputField(): string
    {
        $t = self::token();
        return '<input type="hidden" name="_token" value="' . htmlspecialchars($t, ENT_QUOTES, 'UTF-8') . '">';
    }
}
