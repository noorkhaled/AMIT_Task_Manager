<?php

namespace App\Helpers;

final class Flash
{
    private const KEY = '_flash';

    public static function set(string $type, string $message): void
    {
        $_SESSION[self::KEY][$type][] = $message;
    }

    /** @return array{alerts: array<string,string[]>, toasts: array<string,string[]>} */
    public static function pullAll(): array
    {
        $all = $_SESSION[self::KEY] ?? [];
        unset($_SESSION[self::KEY]);
        // structure buckets
        $alerts = [];
        $toasts = [];
        foreach ($all as $type => $msgs) {
            // decide which go to alerts vs toasts (you can tweak)
            if (in_array($type, ['danger','warning','info'], true)) {
                $alerts[$type] = $msgs;
            } else {
                // default success & anything else -> toast
                $toasts[$type] = $msgs;
            }
        }
        return ['alerts' => $alerts, 'toasts' => $toasts];
    }

    public static function success(string $msg): void { self::set('success', $msg); }
    public static function info(string $msg): void    { self::set('info', $msg); }
    public static function warning(string $msg): void { self::set('warning', $msg); }
    public static function danger(string $msg): void  { self::set('danger', $msg); }
}
