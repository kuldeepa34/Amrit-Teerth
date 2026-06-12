<?php
/**
 * Blog post — single article by ?slug=<slug>.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Models\BlogPost;

$slug = trim((string) ($_GET['slug'] ?? ''));
$post = $slug !== '' ? BlogPost::findBySlug($slug) : null;

if ($post === null) {
    http_response_code(404);
    $pageTitle = 'Article Not Found - ' . SITE_NAME;
} else {
    $pageTitle = $post['title'] . ' - ' . SITE_NAME;
}

$activeNav   = 'blogs';
$contentView = __DIR__ . '/../views/pages/blog-post.php';

require __DIR__ . '/../includes/layout.php';
