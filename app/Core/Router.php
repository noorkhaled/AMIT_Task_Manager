<?php


namespace App\Core;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, string $action): void
    {
        $this->routes['GET'][$this->normalize($path)] = $action;
    }

    public function post(string $path, string $action): void
    {
        $this->routes['POST'][$this->normalize($path)] = $action;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri    = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $path   = $this->normalize($uri);

        $action = $this->routes[$method][$path] ?? null;
        if (!$action) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controller, $methodName] = explode('@', $action);
        $class = "\\App\\Controllers\\$controller";

        if (!class_exists($class)) {
            http_response_code(500);
            echo "Controller not found.";
            return;
        }

        $instance = new $class;
        if (!method_exists($instance, $methodName)) {
            http_response_code(500);
            echo "Action not found.";
            return;
        }

        try {
            $instance->$methodName();
        } catch (\Throwable $t) {
            Logger::error($t->getMessage() . "\n" . $t->getTraceAsString());
            http_response_code(500);
            echo "Something went wrong.";
        }
    }

    private function normalize(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }
}
