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
}
