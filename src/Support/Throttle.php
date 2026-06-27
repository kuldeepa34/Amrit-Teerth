<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Lightweight, session-based rate limiter — enough to blunt brute-force login
 * attempts on shared hosting without an external cache. Attempts are counted
 * per key (e.g. "login") within a sliding decay window.
 *
 *   if (Throttle::tooManyAttempts('login', 5, 300)) { ...locked... }
 *   // on failure:  Throttle::hit('login', 300);
 *   // on success:  Throttle::clear('login');
 */
final class Throttle
{
    private const SESSION_KEY = '_throttle';

    /** True if $key has reached $maxAttempts within the current window. */
    public static function tooManyAttempts(string $key, int $maxAttempts, int $decaySeconds): bool
    {
        $entry = self::entry($key, $decaySeconds);
        return $entry['count'] >= $maxAttempts;
    }

    /** Record one attempt against $key, (re)starting the window if expired. */
    public static function hit(string $key, int $decaySeconds): void
    {
        $entry = self::entry($key, $decaySeconds);
        $entry['count']++;
        $_SESSION[self::SESSION_KEY][$key] = $entry;
    }

    /** Reset the counter for $key (call after a successful action). */
    public static function clear(string $key): void
    {
        unset($_SESSION[self::SESSION_KEY][$key]);
    }

    /** Whole seconds until the window for $key resets (0 if not active). */
    public static function availableIn(string $key): int
    {
        $reset = $_SESSION[self::SESSION_KEY][$key]['reset'] ?? 0;
        return max(0, $reset - time());
    }

    /** Fetch the live entry for $key, resetting it if the window has lapsed. */
    private static function entry(string $key, int $decaySeconds): array
    {
        $entry = $_SESSION[self::SESSION_KEY][$key] ?? null;
        if ($entry === null || ($entry['reset'] ?? 0) <= time()) {
            $entry = ['count' => 0, 'reset' => time() + $decaySeconds];
        }
        return $entry;
    }

    private function __construct()
    {
    }
}
