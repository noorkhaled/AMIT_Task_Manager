<?php

namespace App\Core;

use App\Core\View;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function redirect(string $path): void
    {
        $config = require __DIR__ . '/../../config/config.php';
        $base   = rtrim($config['base_url'], '/');
        header('Location: ' . $base . $path);
        exit;
    }

    protected function requireAuth(): array
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('/login');
        }
        return $_SESSION['user'];
    }
}
