<?php


namespace App\Core;

class Logger
{
    public static function info(string $message): void
    {
        self::write('INFO', $message);
    }

    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    private static function write(string $level, string $message): void
    {
        $config = require __DIR__ . '/../../config/config.php';
        $line = sprintf("[%s] %s: %s\n", date('Y-m-d H:i:s'), $level, $message);
        @file_put_contents($config['log_path'], $line, FILE_APPEND);
    }
}
