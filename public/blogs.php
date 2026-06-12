<?php
/**
 * Blogs — entry point. Topic filter + pagination via the query string.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Models\BlogPost;

const BLOGS_PER_STEP = 3;

$topic    = trim((string) ($_GET['topic'] ?? ''));
$show     = max(BLOGS_PER_STEP, (int) ($_GET['show'] ?? BLOGS_PER_STEP));

$featured = $topic === '' ? BlogPost::featured() : null; // hero only on the unfiltered view
$posts    = BlogPost::list($topic, $show);
$total    = BlogPost::count($topic);
$hasMore  = $total > count($posts);
$nextShow = $show + BLOGS_PER_STEP;
$trending = BlogPost::trending(3);
$topics   = BlogPost::topics();

$pageTitle   = 'Blogs - ' . SITE_NAME . ' Spiritual Services';
$activeNav   = 'blogs';
$contentView = __DIR__ . '/../views/pages/blogs.php';

require __DIR__ . '/../includes/layout.php';
