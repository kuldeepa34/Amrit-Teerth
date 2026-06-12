<?php
/**
 * TEMPLATE — copy this file to `config/database.php` and fill in real values.
 * (config/database.php is gitignored because it holds credentials.)
 *
 * Local dev: the defaults below match database/setup.sql.
 * Hostinger:  use the DB name / user / password from hPanel.
 */

declare(strict_types=1);

return [
    'host'    => getenv('DB_HOST') ?: '127.0.0.1',
    'port'    => getenv('DB_PORT') ?: '3306',
    'name'    => getenv('DB_NAME') ?: 'sacredpath',
    'user'    => getenv('DB_USER') ?: 'sacredpath',
    'pass'    => getenv('DB_PASS') ?: 'sacredpath',
    'charset' => 'utf8mb4',
];
