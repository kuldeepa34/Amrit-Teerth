<?php
/**
 * Site header: fixed top nav. On desktop the nav links sit inline; on mobile
 * they live in a slide-in drawer opened by the hamburger (left of the logo).
 * Set $activeNav (e.g. 'home', 'services') before including to highlight
 * the current page.
 */
$activeNav = $activeNav ?? '';
?>
<body class="antialiased min-h-screen flex flex-col font-body-md text-body-md text-on-surface bg-background">
<!-- TopNavBar -->
<nav id="top-nav" class="fixed top-0 w-full z-50 bg-surface/60 backdrop-blur-md border-b border-white/10 shadow-sm transition-shadow duration-300">
<div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
<!-- Left: hamburger (mobile) + logo -->
<div class="flex items-center gap-3">
<button type="button" id="nav-toggle" aria-label="Open menu" aria-controls="nav-drawer" aria-expanded="false" class="md:hidden w-10 h-10 -ml-2 flex items-center justify-center text-primary hover:bg-surface-container rounded-full transition-colors">
<span class="material-symbols-outlined text-3xl">menu</span>
</button>
<a class="font-display-lg text-display-lg md:font-display-lg md:text-display-lg font-display-lg-mobile text-display-lg-mobile text-primary font-bold" href="index.php"><?= SITE_NAME ?></a>
</div>
<!-- Center: desktop nav links -->
<div class="hidden md:flex items-center gap-gutter">
<?php foreach ($NAV_ITEMS as $item): ?>
    <?php if ($item['key'] === $activeNav): ?>
<a class="font-label-caps text-label-caps text-primary border-b-2 border-primary pb-1 hover:text-secondary transition-colors" href="<?= $item['href'] ?>"><?= $item['label'] ?></a>
    <?php else: ?>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors" href="<?= $item['href'] ?>"><?= $item['label'] ?></a>
    <?php endif; ?>
<?php endforeach; ?>
</div>
<!-- Right: desktop actions + mobile profile -->
<div class="flex items-center gap-4">
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
<!-- Mobile profile menu -->
<div class="md:hidden relative">
<button type="button" id="profile-toggle" aria-haspopup="true" aria-expanded="false" aria-label="Account menu" class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant/40 flex items-center justify-center text-primary hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined"<?= \App\Support\Auth::check() ? ' style="font-variation-settings: \'FILL\' 1;"' : '' ?>>person</span>
</button>
<div id="profile-dropdown" class="hidden absolute right-0 mt-3 w-52 bg-surface-container-lowest rounded-xl shadow-[0_15px_40px_rgba(16,32,59,0.12)] border border-outline-variant/40 py-2 z-50">
<?php if (\App\Support\Auth::check()): ?>
<div class="px-4 py-2 font-label-caps text-label-caps text-on-surface-variant border-b border-outline-variant/30 mb-1">Hi, <?= htmlspecialchars(\App\Support\Auth::user()['name']) ?></div>
<a class="flex items-center gap-3 px-4 py-3 font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors" href="booking.php"><span class="material-symbols-outlined text-[20px] text-primary">event_available</span> Book Darshan</a>
<a class="flex items-center gap-3 px-4 py-3 font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors" href="logout.php"><span class="material-symbols-outlined text-[20px] text-primary">logout</span> Logout</a>
<?php else: ?>
<a class="flex items-center gap-3 px-4 py-3 font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors" href="login.php"><span class="material-symbols-outlined text-[20px] text-primary">login</span> Login</a>
<a class="flex items-center gap-3 px-4 py-3 font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors" href="register.php"><span class="material-symbols-outlined text-[20px] text-primary">person_add</span> Create Account</a>
<?php endif; ?>
</div>
</div>
</div>
</div>
</nav>
<!-- Mobile slide-in nav drawer -->
<div id="nav-backdrop" class="md:hidden fixed inset-0 bg-inverse-surface/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>
<aside id="nav-drawer" class="md:hidden fixed top-0 left-0 h-full w-72 max-w-[82%] bg-surface z-[70] shadow-2xl -translate-x-full transition-transform duration-300 ease-out flex flex-col p-6">
<div class="flex items-center justify-between mb-8">
<span class="font-display-lg-mobile text-display-lg-mobile text-primary font-bold"><?= SITE_NAME ?></span>
<button type="button" id="nav-close" aria-label="Close menu" class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<nav class="flex flex-col gap-1">
<?php foreach ($NAV_ITEMS as $item): ?>
    <?php $isActive = $item['key'] === $activeNav; ?>
<a href="<?= $item['href'] ?>" class="flex items-center gap-4 px-4 py-3 rounded-xl font-label-caps text-label-caps transition-colors <?= $isActive ? 'bg-secondary-container text-on-secondary-container' : 'text-on-surface-variant hover:bg-surface-container' ?>">
<span class="material-symbols-outlined"<?= $isActive ? ' style="font-variation-settings: \'FILL\' 1;"' : '' ?>><?= $item['icon'] ?></span>
<?= $item['label'] ?>
</a>
<?php endforeach; ?>
</nav>
<a href="services.php" class="mt-auto bg-primary text-on-primary text-center px-6 py-4 rounded-full font-label-caps text-label-caps hover:bg-surface-tint transition-colors shadow-sm">Book Service</a>
</aside>
