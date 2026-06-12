<?php
/**
 * Services — entry point.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle   = SITE_NAME . ' - Divine Services';
$activeNav   = 'services';
$contentView = __DIR__ . '/../views/pages/services.php';
$pageScripts = ['assets/js/services.js'];

require __DIR__ . '/../includes/layout.php';
