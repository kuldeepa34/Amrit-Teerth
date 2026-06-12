<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

/**
 * Blog posts — featured, listing, topic filter, trending, topics, single lookup.
 */
final class BlogPost
{
    /** The current featured post (most recent), or null. */
    public static function featured(): ?array
    {
        $row = Connection::get()
            ->query('SELECT * FROM blog_posts WHERE is_featured = 1 ORDER BY published_at DESC LIMIT 1')
            ->fetch();

        return $row ?: null;
    }

    /**
     * Posts for the feed, newest first, limited.
     * - Unfiltered view: excludes the featured post (it has its own hero).
     * - Topic view: includes all posts of that topic (the hero is hidden there),
     *   so the feed matches the topic chip count.
     */
    public static function list(string $topic, int $limit): array
    {
        $pdo = Connection::get();

        if ($topic === '') {
            $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE is_featured = 0 ORDER BY published_at DESC LIMIT :limit');
        } else {
            $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE category = :category ORDER BY published_at DESC LIMIT :limit');
            $stmt->bindValue(':category', $topic);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** Count matching the current view — used for "Load More". */
    public static function count(string $topic): int
    {
        $pdo = Connection::get();

        if ($topic === '') {
            return (int) $pdo->query('SELECT COUNT(*) FROM blog_posts WHERE is_featured = 0')->fetchColumn();
        }
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM blog_posts WHERE category = :category');
        $stmt->execute(['category' => $topic]);

        return (int) $stmt->fetchColumn();
    }

    /** Trending posts for the sidebar. */
    public static function trending(int $limit = 3): array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM blog_posts WHERE is_trending = 1 ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** Categories with post counts, for the "Explore Topics" chips. */
    public static function topics(): array
    {
        return Connection::get()
            ->query('SELECT category, COUNT(*) AS total FROM blog_posts GROUP BY category ORDER BY category ASC')
            ->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM blog_posts WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);

        return $stmt->fetch() ?: null;
    }
}
