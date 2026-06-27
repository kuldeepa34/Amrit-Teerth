<?php
/**
 * Global site configuration.
 * Define site-wide constants and shared data here.
 */

declare(strict_types=1);

// --- Bootstrap: autoloader + session (runs before any page output) ---
$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (!is_file($autoload)) {
    http_response_code(500);
    exit('Composer dependencies missing. Run "composer install" in the project root.');
}
require_once $autoload;

/**
 * Environment detection (mirrors config/database.php).
 * Local dev (CLI / localhost / *.test) shows errors; production hides them.
 */
$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocal  = PHP_SAPI === 'cli'
    || str_contains($httpHost, 'localhost')
    || str_contains($httpHost, '127.0.0.1')
    || str_starts_with($httpHost, '192.168.')
    || str_ends_with(explode(':', $httpHost)[0], '.test');
define('IS_LOCAL', $isLocal);

// --- Error handling: verbose locally, silent (logged) in production ---
error_reporting(E_ALL);
ini_set('display_errors', $isLocal ? '1' : '0');
ini_set('log_errors', '1');

// --- Security response headers (cheap defence-in-depth) ---
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-XSS-Protection: 0');
    if (!$isLocal) {
        // Force HTTPS for a year once live (browsers ignore this on plain HTTP).
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

// --- Hardened session cookie (must be set before session_start) ---
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,                 // not readable from JavaScript
        'samesite' => 'Lax',                // CSRF defence-in-depth
        'secure'   => !$isLocal,            // HTTPS-only in production
    ]);
    session_start();
}

// --- Site metadata ---
define('SITE_NAME', 'Amrit Teerth');
define('SITE_TAGLINE', 'Modern Temple Experience');

/**
 * Primary navigation items.
 * `key`    – used to mark the active link (compare against $activeNav)
 * `label`  – visible text
 * `href`   – target page
 * `icon`   – Material Symbols icon (used by the mobile bottom nav)
 * `mobile` – whether the item appears in the mobile bottom nav
 */
$NAV_ITEMS = [
    ['key' => 'home',     'label' => 'Home',     'href' => 'index.php',    'icon' => 'home',         'mobile' => true],
    ['key' => 'services', 'label' => 'Services', 'href' => 'services.php', 'icon' => 'spa',          'mobile' => true],
    ['key' => 'temples',  'label' => 'Temples',  'href' => 'temples.php',  'icon' => 'temple_hindu', 'mobile' => true],
    ['key' => 'darshan',  'label' => 'Darshan',  'href' => 'darshan.php',  'icon' => 'visibility',   'mobile' => true],
    ['key' => 'blogs',    'label' => 'Blogs',    'href' => 'blogs.php',    'icon' => 'article',      'mobile' => false],
    ['key' => 'about',    'label' => 'About',    'href' => 'about.php',     'icon' => 'info',         'mobile' => false],
    ['key' => 'contact',  'label' => 'Contact',  'href' => 'contact.php',  'icon' => 'mail',         'mobile' => false],
];

// --- Footer link groups ---
$FOOTER_EXPLORE = [
    ['label' => 'Services', 'href' => 'services.php'],
    ['label' => 'Temples',  'href' => 'temples.php'],
    ['label' => 'Darshan',  'href' => 'darshan.php'],
    ['label' => 'Contact',  'href' => 'contact.php'],
];

$FOOTER_LEGAL = [
    ['label' => 'Privacy Policy',   'href' => 'privacy.php'],
    ['label' => 'Terms of Service', 'href' => 'terms.php'],
    ['label' => 'FAQ',              'href' => 'faq.php'],
];

// --- Social links (update hrefs to the real profiles before launch) ---
$SOCIAL_LINKS = [
    ['label' => 'Facebook',  'href' => 'https://facebook.com/amritteerth',   'icon' => 'public'],
    ['label' => 'Instagram', 'href' => 'https://instagram.com/amritteerth',  'icon' => 'photo_camera'],
    ['label' => 'YouTube',   'href' => 'https://youtube.com/@amritteerth',   'icon' => 'play_circle'],
    ['label' => 'Email',     'href' => 'mailto:blessings@amritteerth.com',   'icon' => 'mail'],
];
