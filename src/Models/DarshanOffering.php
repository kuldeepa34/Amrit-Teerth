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

    // ---------------------------------------------------------------------
    //  Admin CRUD
    // ---------------------------------------------------------------------

    /** Storable category values for the admin dropdown (excludes the 'all' tab). */
    public const STORABLE_CATEGORIES = [
        'daily-darshan' => 'Daily Darshan',
        'special-arati' => 'Special Arati',
        'vip-darshan'   => 'VIP Darshan',
        'festivals'     => 'Festivals',
    ];

    public static function count_all(): int
    {
        return (int) Connection::get()->query('SELECT COUNT(*) FROM darshan_offerings')->fetchColumn();
    }

    /**
     * Insert an offering. $data keys: slug, temple_name, location, category,
     * image_url, rating, schedule (array of ['name'=>, 'time'=>]).
     */
    public static function create(array $data): int
    {
        $pdo  = Connection::get();
        $stmt = $pdo->prepare(
            'INSERT INTO darshan_offerings (slug, temple_name, location, category, image_url, rating, schedule)
             VALUES (:slug, :temple_name, :location, :category, :image_url, :rating, :schedule)'
        );
        $stmt->execute(self::bind($data));

        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $params       = self::bind($data);
        $params['id'] = $id;

        Connection::get()->prepare(
            'UPDATE darshan_offerings SET
                slug = :slug, temple_name = :temple_name, location = :location, category = :category,
                image_url = :image_url, rating = :rating, schedule = :schedule
             WHERE id = :id'
        )->execute($params);
    }

    public static function delete(int $id): void
    {
        Connection::get()->prepare('DELETE FROM darshan_offerings WHERE id = :id')->execute(['id' => $id]);
    }

    public static function slugExists(string $slug, ?int $exceptId = null): bool
    {
        $sql    = 'SELECT 1 FROM darshan_offerings WHERE slug = :slug';
        $params = ['slug' => $slug];
        if ($exceptId !== null) {
            $sql .= ' AND id <> :id';
            $params['id'] = $exceptId;
        }
        $stmt = Connection::get()->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }

    private static function bind(array $data): array
    {
        $category = (string) ($data['category'] ?? 'daily-darshan');
        if (!array_key_exists($category, self::STORABLE_CATEGORIES)) {
            $category = 'daily-darshan';
        }

        // Schedule may arrive as an already-built array, or as parallel
        // name[]/time[] inputs from the form. Keep only fully-filled rows.
        $schedule = [];
        foreach ((array) ($data['schedule'] ?? []) as $slot) {
            $name = trim((string) ($slot['name'] ?? ''));
            $time = trim((string) ($slot['time'] ?? ''));
            if ($name !== '' && $time !== '') {
                $schedule[] = ['name' => $name, 'time' => $time];
            }
        }

        return [
            'slug'        => (string) ($data['slug'] ?? ''),
            'temple_name' => (string) ($data['temple_name'] ?? ''),
            'location'    => (string) ($data['location'] ?? ''),
            'category'    => $category,
            'image_url'   => (string) ($data['image_url'] ?? ''),
            'rating'      => (float) ($data['rating'] ?? 5.0),
            'schedule'    => json_encode($schedule, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ];
    }
}
