<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\User;

/**
 * Session-based authentication.
 */
final class Auth
{
    /** Verify credentials and log the user in. Returns true on success. */
    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);

        if ($user !== null && password_verify($password, $user['password_hash'])) {
            self::login($user);
            return true;
        }

        return false;
    }

    /** Store the authenticated user in the session (only safe fields). */
    public static function login(array $user): void
    {
        session_regenerate_id(true); // prevent session fixation
        $_SESSION['user'] = [
            'id'    => (int) $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ];
    }

    public static function check(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    private function __construct()
    {
    }
}
