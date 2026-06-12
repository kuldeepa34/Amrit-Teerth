<?php
/**
 * Darshan — entry point. Category (tab) filter + pagination via query string.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Models\DarshanOffering;

const DARSHAN_PER_STEP = 6;

$category  = DarshanOffering::normaliseCategory($_GET['category'] ?? 'all');
$show      = max(DARSHAN_PER_STEP, (int) ($_GET['show'] ?? DARSHAN_PER_STEP));

$offerings = DarshanOffering::list($category, $show);
$total     = DarshanOffering::count($category);
$hasMore   = $total > count($offerings);
$nextShow  = $show + DARSHAN_PER_STEP;

$pageTitle   = 'Darshan - ' . SITE_NAME;
$activeNav   = 'darshan';
$contentView = __DIR__ . '/../views/pages/darshan.php';

require __DIR__ . '/../includes/layout.php';
