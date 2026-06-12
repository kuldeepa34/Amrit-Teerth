<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Minimal CSRF protection. A per-session token is embedded in every form via
 * Csrf::field() and verified on submit with Csrf::check().
 */
final class Csrf
{
    private const SESSION_KEY = '_csrf';

    /** Returns the session CSRF token, creating one on first use. */
    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::SESSION_KEY];
    }

    /** Ready-to-print hidden input for forms. */
    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(self::token(), ENT_QUOTES) . '">';
    }

    /** Constant-time comparison of a submitted token against the session token. */
    public static function check(?string $token): bool
    {
        return is_string($token)
            && !empty($_SESSION[self::SESSION_KEY])
            && hash_equals($_SESSION[self::SESSION_KEY], $token);
    }

    private function __construct()
    {
    }
}
