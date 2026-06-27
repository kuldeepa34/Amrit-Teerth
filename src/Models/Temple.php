<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

/**
 * Temples table — listing, filtering, search, pagination, single lookup.
 */
final class Temple
{
    /**
     * Filter chips shown on the temples page.
     * key => label. The 'all' key means "no category filter".
     */
    public const CATEGORIES = [
        'all'           => 'All',
        'jyotirlinga'   => 'Jyotirlingas',
        'shakti-peetha' => 'Shakti Peethas',
        'south-indian'  => 'South Indian',
    ];

    /** Normalise a raw category input to a valid filter key ('all' if unknown). */
    public static function normaliseCategory(?string $category): string
    {
        $category = (string) $category;
        return array_key_exists($category, self::CATEGORIES) ? $category : 'all';
    }

    /** Build the shared WHERE clause + bound params for category + search. */
    private static function where(string $category, string $q): array
    {
        $conditions = [];
        $params     = [];

        if ($category !== 'all') {
            $conditions[]        = 'category = :category';
            $params[':category'] = $category;
        }
        if ($q !== '') {
            // Native prepared statements require a distinct placeholder per use.
            $like = '%' . $q . '%';
            $conditions[]      = '(name LIKE :q_name OR location LIKE :q_loc OR deity LIKE :q_deity)';
            $params[':q_name'] = $like;
            $params[':q_loc']  = $like;
            $params[':q_deity'] = $like;
        }

        $sql = $conditions === [] ? '' : ' WHERE ' . implode(' AND ', $conditions);

        return [$sql, $params];
    }

    /** Temples matching category + search, limited to $limit. */
    public static function list(string $category, int $limit, string $q = ''): array
    {
        [$where, $params] = self::where($category, $q);

        $stmt = Connection::get()->prepare('SELECT * FROM temples' . $where . ' ORDER BY id ASC LIMIT :limit');
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** Total temples matching category + search — used to decide "Load More". */
    public static function count(string $category, string $q = ''): int
    {
        [$where, $params] = self::where($category, $q);

        $stmt = Connection::get()->prepare('SELECT COUNT(*) FROM temples' . $where);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM temples WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);

        return $stmt->fetch() ?: null;
    }

    // ---------------------------------------------------------------------
    //  Admin CRUD
    // ---------------------------------------------------------------------

    /** Every temple, newest first — for the admin list. */
    public static function all(): array
    {
        return Connection::get()
            ->query('SELECT * FROM temples ORDER BY id DESC')
            ->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM temples WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public static function count_all(): int
    {
        return (int) Connection::get()->query('SELECT COUNT(*) FROM temples')->fetchColumn();
    }

    /** Insert a temple. $data keys: slug, name, deity, location, category, description, image_url, rating. */
    public static function create(array $data): int
    {
        $pdo  = Connection::get();
        $stmt = $pdo->prepare(
            'INSERT INTO temples (slug, name, deity, location, category, description, image_url, rating)
             VALUES (:slug, :name, :deity, :location, :category, :description, :image_url, :rating)'
        );
        $stmt->execute(self::bind($data));

        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $params       = self::bind($data);
        $params['id'] = $id;

        Connection::get()->prepare(
            'UPDATE temples SET
                slug = :slug, name = :name, deity = :deity, location = :location,
                category = :category, description = :description, image_url = :image_url, rating = :rating
             WHERE id = :id'
        )->execute($params);
    }

    public static function delete(int $id): void
    {
        Connection::get()->prepare('DELETE FROM temples WHERE id = :id')->execute(['id' => $id]);
    }

    /** Whether a slug is already taken (optionally excluding one temple id). */
    public static function slugExists(string $slug, ?int $exceptId = null): bool
    {
        $sql    = 'SELECT 1 FROM temples WHERE slug = :slug';
        $params = ['slug' => $slug];
        if ($exceptId !== null) {
            $sql .= ' AND id <> :id';
            $params['id'] = $exceptId;
        }
        $stmt = Connection::get()->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Storable category values for the admin dropdown.
     * (CATEGORIES includes the 'all' filter key, which is never stored.)
     */
    public const STORABLE_CATEGORIES = [
        'jyotirlinga'   => 'Jyotirlinga',
        'shakti-peetha' => 'Shakti Peetha',
        'south-indian'  => 'South Indian',
        'other'         => 'Other',
    ];

    /** Normalise input to exactly the columns we write. */
    private static function bind(array $data): array
    {
        $category = (string) ($data['category'] ?? 'other');
        if (!array_key_exists($category, self::STORABLE_CATEGORIES)) {
            $category = 'other';
        }

        return [
            'slug'        => (string) ($data['slug'] ?? ''),
            'name'        => (string) ($data['name'] ?? ''),
            'deity'       => ($data['deity'] ?? '') !== '' ? (string) $data['deity'] : null,
            'location'    => (string) ($data['location'] ?? ''),
            'category'    => $category,
            'description' => (string) ($data['description'] ?? ''),
            'image_url'   => (string) ($data['image_url'] ?? ''),
            'rating'      => (float) ($data['rating'] ?? 5.0),
        ];
    }
}
