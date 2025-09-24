<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;
use PDO;

class TaskRepository implements TaskRepositoryInterface
{
    public function paginateByUser(int $userId, $limit, int $offset = 0): array
    {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Task::class);
    }

    public function countByUser(int $userId): int
    {
        $stmt = Database::getConnection()->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return (int)$stmt->fetchColumn();
    }

    public function findOneForUser(int $id, int $userId): ?Task
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1"
        );
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Task::class);
        $task = $stmt->fetch();
        return $task ?: null;
    }

    public function create(Task $task): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO tasks (user_id, title, description, status, due_date) 
             VALUES (:user_id, :title, :desc, :status, :due)"
        );
        $stmt->execute([
            ':user_id' => $task->user_id,
            ':title' => $task->title,
            ':desc' => $task->description,
            ':status' => $task->status,
            ':due' => $task->due_date,
        ]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(Task $task, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare(
            "UPDATE tasks SET title=:title, description=:desc, status=:status, due_date=:due 
             WHERE id=:id AND user_id=:user_id"
        );
        return $stmt->execute([
            ':title' => $task->title,
            ':desc'  => $task->description,
            ':status'=> $task->status,
            ':due'   => $task->due_date,
            ':id'    => $task->id,
            ':user_id'   => $userId,
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare(
            "DELETE FROM tasks WHERE id=:id AND user_id=:user_id"
        );
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }
}
