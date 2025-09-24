<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\User;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE email = :e LIMIT 1");
        $stmt->execute([':e' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?User
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO users (name, email, password) VALUES (:n, :e, :p)"
        );
        $stmt->execute([':n' => $name, ':e' => $email, ':p' => $passwordHash]);
        return (int)Database::getConnection()->lastInsertId();
    }
}
