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
}
