<?php

namespace App\Core;

use App\Helpers\Csrf;

class View
{
    public static function render(string $template, array $data = []): void
    {
        $config = require __DIR__ . '/../../config/config.php';
        $base   = rtrim($config['base_url'], '/');

        $file = __DIR__ . '/../../views/' . $template . '.php';
        if (!is_file($file)) {
            http_response_code(500);
            echo "View not found: $template";
            return;
        }
        extract($data);
        $csrfField = Csrf::inputField();
        include __DIR__ . '/../../views/partials/header.php';
        include $file;
        include __DIR__ . '/../../views/partials/footer.php';
    }
}
