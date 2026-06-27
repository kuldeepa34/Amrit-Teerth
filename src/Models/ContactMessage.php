<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;

/**
 * Contact-form messages table.
 */
final class ContactMessage
{
    public static function create(
        string $fullName,
        string $email,
        ?string $serviceInterest,
        string $message
    ): void {
        $stmt = Connection::get()->prepare(
            'INSERT INTO contact_messages (full_name, email, service_interest, message)
             VALUES (:full_name, :email, :service_interest, :message)'
        );
        $stmt->execute([
            'full_name'        => $fullName,
            'email'            => $email,
            'service_interest' => $serviceInterest !== '' ? $serviceInterest : null,
            'message'          => $message,
        ]);
    }

    /** All messages, newest first — for the admin inbox. */
    public static function all(): array
    {
        return Connection::get()
            ->query('SELECT * FROM contact_messages ORDER BY created_at DESC')
            ->fetchAll();
    }

    public static function count_all(): int
    {
        return (int) Connection::get()->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();
    }

    public static function delete(int $id): void
    {
        Connection::get()->prepare('DELETE FROM contact_messages WHERE id = :id')->execute(['id' => $id]);
    }
}
