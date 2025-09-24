<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    public function __construct(private UserRepository $users) {}

    public function register(string $name, string $email, string $password): array
    {
        $name  = trim($name);
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return [false, 'Invalid email'];
        }
        if (strlen($name) < 2) {
            return [false, 'Name too short'];
        }
        if (strlen($password) < 8) {
            return [false, 'Password must be at least 8 chars'];
        }
        if ($this->users->findByEmail($email)) {
            return [false, 'Email already registered'];
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $id = $this->users->create($name, $email, $hash);
        $_SESSION['user'] = ['id' => $id, 'name' => $name, 'email' => $email];
        return [true, null];
    }

    public function login(string $email, string $password): array
    {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if (!$email) return [false, 'Invalid email'];

        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            return [false, 'Invalid credentials'];
        }
        $_SESSION['user'] = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email];
        return [true, null];
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
