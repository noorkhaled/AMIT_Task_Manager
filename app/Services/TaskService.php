<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(private TaskRepository $tasks) {}

    public function listForUser(int $userId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $rows = $this->tasks->paginateByUser($userId, $perPage, $offset);
        $total = $this->tasks->countByUser($userId);
        return [$rows, $total, $page, $perPage];
    }

    public function create(int $userId, array $input): array
    {
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $status = $input['status'] ?? 'pending';
        $due = $input['due_date'] ?? null;

        if ($title === '') return [false, 'Title is required'];
        if (!in_array($status, ['pending','in_progress','done'], true)) {
            return [false, 'Invalid status'];
        }
        if ($due && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $due)) {
            return [false, 'Invalid date (YYYY-MM-DD)'];
        }

        $task = new Task();
        $task->user_id = $userId;
        $task->title = $title;
        $task->description = $description ?: null;
        $task->status = $status;
        $task->due_date = $due ?: null;

        $id = $this->tasks->create($task);
        return [true, $id];
    }

    public function update(int $userId, int $id, array $input): array
    {
        $task = $this->tasks->findOneForUser($id, $userId);
        if (!$task) return [false, 'Task not found'];

        $title = trim($input['title'] ?? $task->title);
        $desc  = trim($input['description'] ?? ($task->description ?? ''));
        $status= $input['status'] ?? $task->status;
        $due   = $input['due_date'] ?? $task->due_date;

        if ($title === '') return [false, 'Title is required'];
        if (!in_array($status, ['pending','in_progress','done'], true)) {
            return [false, 'Invalid status'];
        }
        if ($due && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $due)) {
            return [false, 'Invalid date (YYYY-MM-DD)'];
        }

        $task->title = $title;
        $task->description = $desc ?: null;
        $task->status = $status;
        $task->due_date = $due ?: null;

        $ok = $this->tasks->update($task, $userId);
        return [$ok, $ok ? null : 'Update failed'];
    }

    public function delete(int $userId, int $id): bool
    {
        return $this->tasks->delete($id, $userId);
    }

    public function findOneForUser(int $userId, int $id)
    {
        return $this->tasks->findOneForUser($id, $userId);
    }
}
