<?php
/**
 * Home — entry point.
 * Sets up page metadata, then renders the home view inside the base layout.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle   = SITE_NAME . ' - ' . SITE_TAGLINE;
$activeNav   = 'home';
$contentView = __DIR__ . '/../views/pages/home.php';

require __DIR__ . '/../includes/layout.php';
