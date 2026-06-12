<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

/**
 * Darshan bookings.
 */
final class Booking
{
    public static function create(
        int $userId,
        int $offeringId,
        string $offeringName,
        string $slotName,
        string $slotTime,
        string $bookingDate,
        int $devotees
    ): int {
        $pdo = Connection::get();
        $stmt = $pdo->prepare(
            'INSERT INTO bookings
                (user_id, offering_id, offering_name, slot_name, slot_time, booking_date, devotees)
             VALUES
                (:user_id, :offering_id, :offering_name, :slot_name, :slot_time, :booking_date, :devotees)'
        );
        $stmt->execute([
            'user_id'       => $userId,
            'offering_id'   => $offeringId,
            'offering_name' => $offeringName,
            'slot_name'     => $slotName,
            'slot_time'     => $slotTime,
            'booking_date'  => $bookingDate,
            'devotees'      => $devotees,
        ]);

        return (int) $pdo->lastInsertId();
    }

    /** A user's most recent bookings. */
    public static function forUser(int $userId, int $limit = 5): array
    {
        $stmt = Connection::get()->prepare(
            'SELECT * FROM bookings WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit'
        );
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
