<?php
/**
 * Contact — entry point.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle   = 'Contact - ' . SITE_NAME;
$activeNav   = 'contact';
$contentView = __DIR__ . '/../views/pages/contact.php';

require __DIR__ . '/../includes/layout.php';
