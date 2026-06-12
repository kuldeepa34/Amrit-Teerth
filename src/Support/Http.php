<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Tiny HTTP redirect helpers (Post-Redirect-Get).
 */
final class Http
{
    /** Redirect to a specific URL and stop. */
    public static function to(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Redirect back to the page the request came from (the form's page),
     * falling back to $fallback when no referer is available. Only same-host
     * referers are honoured to avoid open-redirects.
     */
    public static function back(string $fallback = 'index.php'): never
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $host    = $_SERVER['HTTP_HOST'] ?? '';

        if ($referer !== '' && $host !== '' && str_contains(parse_url($referer, PHP_URL_HOST) ?? '', $host)) {
            self::to($referer);
        }
        self::to($fallback);
    }

    private function __construct()
    {
    }
}
