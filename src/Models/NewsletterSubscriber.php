<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;

/**
 * Newsletter subscribers table.
 */
final class NewsletterSubscriber
{
    /**
     * Add an email to the list. Duplicate emails are ignored silently
     * (the UNIQUE index + INSERT IGNORE keep the list clean).
     */
    public static function subscribe(string $email): void
    {
        $stmt = Connection::get()->prepare(
            'INSERT IGNORE INTO newsletter_subscribers (email) VALUES (:email)'
        );
        $stmt->execute(['email' => $email]);
    }

    /** All subscribers, newest first — for the admin list / export. */
    public static function all(): array
    {
        return Connection::get()
            ->query('SELECT * FROM newsletter_subscribers ORDER BY created_at DESC')
            ->fetchAll();
    }

    public static function count_all(): int
    {
        return (int) Connection::get()->query('SELECT COUNT(*) FROM newsletter_subscribers')->fetchColumn();
    }

    public static function delete(int $id): void
    {
        Connection::get()->prepare('DELETE FROM newsletter_subscribers WHERE id = :id')->execute(['id' => $id]);
    }
}
