<?php

namespace App\Repositories;

use App\Models\Task;

interface TaskRepositoryInterface
{
    /** @return Task[] */
    public function paginateByUser(int $userId, int $limit, int $offset = 0): array;

    public function countByUser(int $userId): int;

    public function findOneForUser(int $id, int $userId): ?Task;

    public function create(Task $task): int;

    public function update(Task $task, int $userId): bool;

    public function delete(int $id, int $userId): bool;
}
