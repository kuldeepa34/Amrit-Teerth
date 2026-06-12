<?php
/**
 * Temple details — single temple by ?temple=<slug>.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Models\Temple;

$slug   = trim((string) ($_GET['temple'] ?? ''));
$temple = $slug !== '' ? Temple::findBySlug($slug) : null;

if ($temple === null) {
    http_response_code(404);
    $pageTitle = 'Temple Not Found - ' . SITE_NAME;
} else {
    $pageTitle = $temple['name'] . ' - ' . SITE_NAME;
}

$activeNav   = 'temples';
$contentView = __DIR__ . '/../views/pages/temple-details.php';

require __DIR__ . '/../includes/layout.php';
