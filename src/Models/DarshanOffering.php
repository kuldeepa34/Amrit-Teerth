<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

/**
 * Darshan offerings — listing, category (tab) filter, pagination.
 */
final class DarshanOffering
{
    /** Filter tabs. The 'all' key means "no category filter". */
    public const CATEGORIES = [
        'all'           => 'All Experiences',
        'daily-darshan' => 'Daily Darshan',
        'special-arati' => 'Special Arati',
        'vip-darshan'   => 'VIP Darshan',
        'festivals'     => 'Festivals',
    ];

    public static function normaliseCategory(?string $category): string
    {
        $category = (string) $category;
        return array_key_exists($category, self::CATEGORIES) ? $category : 'all';
    }

    public static function list(string $category, int $limit): array
    {
        $pdo = Connection::get();

        if ($category === 'all') {
            $stmt = $pdo->prepare('SELECT * FROM darshan_offerings ORDER BY id ASC LIMIT :limit');
        } else {
            $stmt = $pdo->prepare('SELECT * FROM darshan_offerings WHERE category = :category ORDER BY id ASC LIMIT :limit');
            $stmt->bindValue(':category', $category);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** All offerings (for the booking dropdown), ordered by temple name. */
    public static function all(): array
    {
        return Connection::get()
            ->query('SELECT * FROM darshan_offerings ORDER BY temple_name ASC')
            ->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM darshan_offerings WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM darshan_offerings WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);

        return $stmt->fetch() ?: null;
    }

    public static function count(string $category): int
    {
        $pdo = Connection::get();

        if ($category === 'all') {
            return (int) $pdo->query('SELECT COUNT(*) FROM darshan_offerings')->fetchColumn();
        }
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM darshan_offerings WHERE category = :category');
        $stmt->execute(['category' => $category]);

        return (int) $stmt->fetchColumn();
    }
}
