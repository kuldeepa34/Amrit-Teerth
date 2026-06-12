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

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Site metadata ---
define('SITE_NAME', 'SacredPath');
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
    ['label' => 'Facebook',  'href' => 'https://facebook.com/sacredpath',   'icon' => 'public'],
    ['label' => 'Instagram', 'href' => 'https://instagram.com/sacredpath',  'icon' => 'photo_camera'],
    ['label' => 'YouTube',   'href' => 'https://youtube.com/@sacredpath',   'icon' => 'play_circle'],
    ['label' => 'Email',     'href' => 'mailto:blessings@sacredpath.com',   'icon' => 'mail'],
];
