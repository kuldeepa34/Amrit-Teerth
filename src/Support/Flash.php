<?php

declare(strict_types=1);

namespace App\Support;

/**
 * One-time "flash" messages stored in the session, used to show feedback
 * after a redirect (Post-Redirect-Get). Messages are keyed by channel
 * (e.g. 'newsletter', 'contact') so different forms don't collide.
 */
final class Flash
{
    public static function set(string $key, string $message, string $type = 'success'): void
    {
        $_SESSION['_flash'][$key] = ['message' => $message, 'type' => $type];
    }

    /** Returns ['message' => ..., 'type' => ...] once, then clears it. */
    public static function pull(string $key): ?array
    {
        if (empty($_SESSION['_flash'][$key])) {
            return null;
        }
        $flash = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $flash;
    }

    private function __construct()
    {
    }
}
