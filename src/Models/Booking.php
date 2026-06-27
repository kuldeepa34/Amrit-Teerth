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

    /**
     * Whether this user already holds a confirmed booking for the same
     * offering, date and slot — used to block accidental double-bookings.
     */
    public static function existsForSlot(int $userId, int $offeringId, string $bookingDate, string $slotName): bool
    {
        $stmt = Connection::get()->prepare(
            'SELECT 1 FROM bookings
             WHERE user_id = :user_id
               AND offering_id = :offering_id
               AND booking_date = :booking_date
               AND slot_name = :slot_name
               AND status = :status
             LIMIT 1'
        );
        $stmt->execute([
            'user_id'      => $userId,
            'offering_id'  => $offeringId,
            'booking_date' => $bookingDate,
            'slot_name'    => $slotName,
            'status'       => 'confirmed',
        ]);

        return (bool) $stmt->fetchColumn();
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

    /** All bookings with the booking user's name/email — for the admin list. */
    public static function all(): array
    {
        return Connection::get()->query(
            'SELECT b.*, u.name AS user_name, u.email AS user_email
             FROM bookings b
             LEFT JOIN users u ON u.id = b.user_id
             ORDER BY b.created_at DESC'
        )->fetchAll();
    }

    public static function count_all(): int
    {
        return (int) Connection::get()->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
    }

    public static function delete(int $id): void
    {
        Connection::get()->prepare('DELETE FROM bookings WHERE id = :id')->execute(['id' => $id]);
    }
}
