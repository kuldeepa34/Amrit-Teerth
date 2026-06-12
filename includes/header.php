<?php
/**
 * Site header: fixed top nav (desktop) + bottom nav (mobile).
 * Set $activeNav (e.g. 'home', 'services') before including to highlight
 * the current page.
 */
$activeNav = $activeNav ?? '';
?>
<body class="antialiased min-h-screen flex flex-col font-body-md text-body-md text-on-surface bg-background">
<!-- TopNavBar -->
<nav id="top-nav" class="fixed top-0 w-full z-50 bg-surface/60 backdrop-blur-md border-b border-white/10 shadow-sm transition-shadow duration-300">
<div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
<a class="font-display-lg text-display-lg md:font-display-lg md:text-display-lg font-display-lg-mobile text-display-lg-mobile text-primary font-bold" href="index.php">
                <?= SITE_NAME ?>
            </a>
<div class="hidden md:flex items-center gap-gutter">
<?php foreach ($NAV_ITEMS as $item): ?>
    <?php if ($item['key'] === $activeNav): ?>
<a class="font-label-caps text-label-caps text-primary border-b-2 border-primary pb-1 hover:text-secondary transition-colors" href="<?= $item['href'] ?>"><?= $item['label'] ?></a>
    <?php else: ?>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors" href="<?= $item['href'] ?>"><?= $item['label'] ?></a>
    <?php endif; ?>
<?php endforeach; ?>
</div>
<div class="hidden md:flex items-center gap-4">
<?php if (\App\Support\Auth::check()): ?>
<span class="font-label-caps text-label-caps text-on-surface-variant">Hi, <?= htmlspecialchars(\App\Support\Auth::user()['name']) ?></span>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors" href="logout.php">Logout</a>
<a class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-caps text-label-caps hover:bg-surface-tint transition-colors shadow-sm" href="services.php">Book Service</a>
<?php else: ?>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors" href="login.php">Login</a>
<a class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-caps text-label-caps hover:bg-surface-tint transition-colors shadow-sm" href="services.php">Book Service</a>
<?php endif; ?>
</div>
</div>
</nav>
<!-- Mobile Bottom Nav -->
<div class="md:hidden fixed bottom-0 w-full z-50 bg-surface/90 backdrop-blur-md shadow-[0_-4px_20px_rgba(16,32,59,0.04)] pb-safe">
<div class="flex justify-around items-center py-4 px-2">
<?php foreach ($NAV_ITEMS as $item): ?>
    <?php if (!$item['mobile']) continue; ?>
    <?php $isActive = $item['key'] === $activeNav; ?>
<a class="flex flex-col items-center gap-1 <?= $isActive ? 'text-primary' : 'text-on-surface-variant hover:text-secondary' ?>" href="<?= $item['href'] ?>">
<span class="material-symbols-outlined"<?= $isActive ? ' style="font-variation-settings: \'FILL\' 1;"' : '' ?>><?= $item['icon'] ?></span>
<span class="font-label-caps text-[10px]"><?= $item['label'] ?></span>
</a>
<?php endforeach; ?>
</div>
</div>
