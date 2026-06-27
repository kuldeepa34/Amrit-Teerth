<?php
/**
 * Admin layout — sidebar + topbar chrome around an admin view.
 *
 * Entry pages (public/admin/*.php) set before requiring this file:
 *   $pageTitle    – document title (optional)
 *   $adminNav     – active sidebar key: dashboard|temples|darshan|bookings|messages|subscribers|users
 *   $contentView  – absolute path to the page's view file (required)
 */

declare(strict_types=1);

use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Flash;

if (!isset($contentView) || !is_file($contentView)) {
    http_response_code(500);
    exit('Admin layout error: $contentView is not set to a valid view file.');
}

$adminNav    = $adminNav ?? 'dashboard';
$pageTitle   = ($pageTitle ?? 'Admin') . ' - ' . SITE_NAME;
$assetPrefix = '../';   // admin pages live one level below the web root

$ADMIN_NAV = [
    ['key' => 'dashboard',   'href' => 'index.php',       'label' => 'Dashboard',   'icon' => 'dashboard'],
    ['key' => 'temples',     'href' => 'temples.php',     'label' => 'Temples',     'icon' => 'temple_hindu'],
    ['key' => 'darshan',     'href' => 'darshan.php',     'label' => 'Puja / Darshan', 'icon' => 'self_improvement'],
    ['key' => 'bookings',    'href' => 'bookings.php',    'label' => 'Bookings',    'icon' => 'event_available'],
    ['key' => 'messages',    'href' => 'messages.php',    'label' => 'Messages',    'icon' => 'mail'],
    ['key' => 'subscribers', 'href' => 'subscribers.php', 'label' => 'Subscribers', 'icon' => 'alternate_email'],
    ['key' => 'users',       'href' => 'users.php',       'label' => 'Users',       'icon' => 'group'],
];

require __DIR__ . '/head.php';
?>
<body class="antialiased min-h-screen font-body-md text-body-md text-on-surface bg-surface-container-low">
<div class="flex min-h-screen">
<!-- Sidebar -->
<aside id="admin-sidebar" class="fixed md:sticky top-0 left-0 z-50 h-screen w-64 shrink-0 bg-surface-container-lowest border-r border-outline-variant flex flex-col -translate-x-full md:translate-x-0 transition-transform duration-300">
<div class="px-6 py-5 border-b border-outline-variant">
<a href="index.php" class="font-display-lg text-headline-md text-primary">Amrit Teerth</a>
<p class="font-label-caps text-label-caps text-on-surface-variant mt-1">Admin Panel</p>
</div>
<nav class="flex-1 overflow-y-auto py-4 px-3 flex flex-col gap-1">
<?php foreach ($ADMIN_NAV as $item): $isActive = $item['key'] === $adminNav; ?>
<a href="<?= $item['href'] ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-caps text-label-caps transition-colors <?= $isActive ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container' ?>">
<span class="material-symbols-outlined text-[20px]"<?= $isActive ? ' style="font-variation-settings: \'FILL\' 1;"' : '' ?>><?= $item['icon'] ?></span>
<?= $item['label'] ?>
</a>
<?php endforeach; ?>
</nav>
<div class="border-t border-outline-variant p-3 flex flex-col gap-1">
<a href="../index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined text-[20px]">open_in_new</span> View Site
</a>
<a href="../logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined text-[20px]">logout</span> Logout
</a>
</div>
</aside>
<!-- Sidebar backdrop (mobile) -->
<div id="admin-backdrop" class="md:hidden fixed inset-0 bg-inverse-surface/40 backdrop-blur-sm z-40 hidden"></div>

<!-- Main column -->
<div class="flex-1 min-w-0 flex flex-col">
<header class="sticky top-0 z-30 bg-surface/80 backdrop-blur-md border-b border-outline-variant px-4 md:px-8 py-4 flex items-center justify-between">
<div class="flex items-center gap-3">
<button type="button" id="admin-menu-toggle" aria-label="Open menu" class="md:hidden w-10 h-10 -ml-2 flex items-center justify-center text-primary hover:bg-surface-container rounded-full transition-colors">
<span class="material-symbols-outlined">menu</span>
</button>
<h1 class="font-headline-sm text-headline-sm text-primary"><?= htmlspecialchars($adminPageHeading ?? 'Dashboard') ?></h1>
</div>
<div class="flex items-center gap-3">
<span class="hidden sm:inline font-label-caps text-label-caps text-on-surface-variant">Hi, <?= htmlspecialchars(Auth::user()['name'] ?? 'Admin') ?></span>
<span class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-caps text-label-caps"><?= htmlspecialchars(strtoupper(substr(Auth::user()['name'] ?? 'A', 0, 1))) ?></span>
</div>
</header>

<main class="flex-1 p-4 md:p-8 max-w-[1100px] w-full">
<?php if ($flash = Flash::pull('admin')): ?>
<div class="mb-6 rounded-xl px-4 py-3 font-body-md text-body-md flex items-center gap-2 <?= $flash['type'] === 'error' ? 'bg-error-container text-on-error-container' : 'bg-secondary-container text-on-secondary-container' ?>">
<span class="material-symbols-outlined text-[20px]"><?= $flash['type'] === 'error' ? 'error' : 'check_circle' ?></span>
<?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>
<?php require $contentView; ?>
</main>
</div>
</div>
<script>
  (function () {
    var btn = document.getElementById('admin-menu-toggle');
    var bar = document.getElementById('admin-sidebar');
    var bd  = document.getElementById('admin-backdrop');
    function open()  { bar.classList.remove('-translate-x-full'); bd.classList.remove('hidden'); }
    function close() { bar.classList.add('-translate-x-full'); bd.classList.add('hidden'); }
    if (btn) btn.addEventListener('click', open);
    if (bd)  bd.addEventListener('click', close);
  })();
</script>
</body>
</html>
