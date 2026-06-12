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
}
