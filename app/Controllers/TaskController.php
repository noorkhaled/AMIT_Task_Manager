<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Repositories\TaskRepository;
use App\Services\TaskService;

class TaskController extends Controller
{
    private TaskService $tasks;

    public function __construct()
    {
        $this->tasks = new TaskService(new TaskRepository());
    }

    public function index(): void
    {
        $user = $this->requireAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        [$rows, $total, $page, $perPage] = $this->tasks->listForUser((int)$user['id'], $page);

        $this->view('tasks/index', [
            'title'   => 'My Tasks',
            'tasks'   => $rows,
            'total'   => $total,
            'page'    => $page,
            'perPage' => $perPage,
        ]);
    }

    public function createForm(): void
    {
        $this->requireAuth();
        $this->view('tasks/create', ['title' => 'Create Task']);
    }

    public function store(): void
    {
        $user = $this->requireAuth();
        if (!Csrf::verify($_POST['_token'] ?? '')) { http_response_code(419); exit('CSRF failed'); }

        [$ok, $msgOrId] = $this->tasks->create((int)$user['id'], $_POST);
        if ($ok) {
            Flash::success('Task created successfully.');
            Logger::info("Task created for {$_POST['title']}");
            $this->redirect('/tasks');
        } else {
            $this->view('tasks/create', ['title' => 'Create Task', 'error' => $msgOrId, 'old' => $_POST]);
        }
    }
    public function show(): void
    {
        $user = $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $task = $this->tasks->findOneForUser((int)$user['id'], $id);
        if (!$task) { http_response_code(404); exit('Task not found'); }
        $this->view('tasks/show', ['title' => 'Task Details', 'task' => $task]);
    }
    public function editForm(): void
    {
        $user = $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $task = $this->tasks->findOneForUser((int)$user['id'], $id);
        if (!$task) { http_response_code(404); exit('Task not found'); }
        $this->view('tasks/edit', ['title' => 'Edit Task', 'task' => $task]);
    }

    public function update(): void
    {
        $user = $this->requireAuth();
        if (!Csrf::verify($_POST['_token'] ?? '')) { http_response_code(419); exit('CSRF failed'); }
        $id = (int)($_POST['id'] ?? 0);
        [$ok, $err] = $this->tasks->update((int)$user['id'], $id, $_POST);
        if ($ok) {
            Flash::success('Task updated successfully.');
            Logger::info("Task updated for {$_POST['title']}");
            $this->redirect('/tasks');
        } else {
            $_GET['id'] = $id;
            $this->view('tasks/edit', ['title'=>'Edit Task','error'=>$err,'task'=>$this->tasks->findOneForUser((int)$user['id'], $id)]);
        }
    }

    public function destroy(): void
    {
        $user = $this->requireAuth();
        if (!Csrf::verify($_POST['_token'] ?? '')) { http_response_code(419); exit('CSRF failed'); }
        $id = (int)($_POST['id'] ?? 0);
        $this->tasks->delete((int)$user['id'], $id);
        Flash::success('Task deleted successfully.');
        Logger::info("Task deleted with ID {$id}");
        $this->redirect('/tasks');
    }
}
