<?php

namespace App\Models;
class Task
{
    public ?int $id = null;
    public int $user_id;
    public string $title;
    public ?string $description = null;
    public string $status = 'pending';
    public ?string $due_date = null;
    public string $created_at;
}
