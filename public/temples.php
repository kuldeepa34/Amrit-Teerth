<?php
/**
 * Temples — entry point. Reads filter/search/pagination from the query string.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Models\Temple;

const TEMPLES_PER_STEP = 6;   // initial count + how the page grows

$category = Temple::normaliseCategory($_GET['category'] ?? 'all');
$search   = trim((string) ($_GET['q'] ?? ''));
$show     = max(TEMPLES_PER_STEP, (int) ($_GET['show'] ?? TEMPLES_PER_STEP));

$temples  = Temple::list($category, $show, $search);
$total    = Temple::count($category, $search);
$hasMore  = $total > count($temples);
$nextShow = $show + TEMPLES_PER_STEP;

$pageTitle   = 'Temples - ' . SITE_NAME;
$activeNav   = 'temples';
$contentView = __DIR__ . '/../views/pages/temples.php';

require __DIR__ . '/../includes/layout.php';
