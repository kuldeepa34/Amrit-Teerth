<?php
/**
 * Convenience bootstrap.
 *
 * config/config.php is the real entry point — it loads Composer's autoloader,
 * starts the session, and defines site config. This file simply forwards to it
 * so `require __DIR__ . '/bootstrap.php';` also works.
 */

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
