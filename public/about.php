<?php
/**
 * About — entry point.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle   = 'About ' . SITE_NAME;
$activeNav   = 'about';
$contentView = __DIR__ . '/../views/pages/about.php';

require __DIR__ . '/../includes/layout.php';
