<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;

/**
 * Users table + password handling.
 */
final class User
{
    /** Create a user with a securely hashed password. Returns the new id. */
    public static function create(string $name, string $email, string $password): int
    {
        $pdo = Connection::get();
        $stmt = $pdo->prepare(
            'INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :hash)'
        );
        $stmt->execute([
            'name'  => $name,
            'email' => $email,
            'hash'  => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return (int) $pdo->lastInsertId();
    }

    /** Fetch a user row by email, or null if not found. */
    public static function findByEmail(string $email): ?array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        return $stmt->fetch() ?: null;
    }

    /** Whether an email is already registered. */
    public static function emailExists(string $email): bool
    {
        $stmt = Connection::get()->prepare('SELECT 1 FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        return (bool) $stmt->fetchColumn();
    }
}
