<?php
/**
 * TEMPLATE — copy this file to `config/mail.php` and fill in real SMTP values.
 * (config/mail.php is gitignored because it holds credentials.)
 *
 * Leave 'host' empty to disable email sending (form data is still stored in
 * the database). On Hostinger, use your hPanel email account's SMTP details.
 */

declare(strict_types=1);

return [
    'host'       => getenv('MAIL_HOST') ?: '',          // e.g. smtp.hostinger.com  (empty = disabled)
    'port'       => (int) (getenv('MAIL_PORT') ?: 587),
    'username'   => getenv('MAIL_USERNAME') ?: '',
    'password'   => getenv('MAIL_PASSWORD') ?: '',
    'encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls',  // 'tls' or 'ssl'
    'from'       => getenv('MAIL_FROM') ?: 'no-reply@sacredpath.com',
    'from_name'  => getenv('MAIL_FROM_NAME') ?: 'SacredPath',
    'to'         => getenv('MAIL_TO') ?: 'blessings@sacredpath.com',
];
