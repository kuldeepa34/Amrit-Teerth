<?php
/**
 * Site footer + closing document tags.
 *
 * Optional: set $pageScripts (array of paths relative to the web root, e.g.
 * ['assets/js/services.js']) before this file is included to load
 * page-specific scripts just before </body>.
 */
$pageScripts = $pageScripts ?? [];
?>
<!-- Footer -->
<footer class="bg-surface-container-lowest border-t border-outline-variant mt-auto">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop py-stack-lg max-w-container-max mx-auto">
<div class="md:col-span-1 flex flex-col gap-4">
<span class="font-display-lg text-display-lg md:font-display-lg md:text-display-lg font-display-lg-mobile text-display-lg-mobile text-primary"><?= SITE_NAME ?></span>
<p class="font-body-md text-body-md text-on-surface-variant">Elevating spiritual journeys through seamless connection.</p>
</div>
<div class="md:col-span-2 grid grid-cols-2 gap-8">
<div class="flex flex-col gap-4">
<span class="font-label-caps text-label-caps text-on-surface">Explore</span>
<?php foreach ($FOOTER_EXPLORE as $link): ?>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-opacity duration-300" href="<?= $link['href'] ?>"><?= $link['label'] ?></a>
<?php endforeach; ?>
</div>
<div class="flex flex-col gap-4">
<span class="font-label-caps text-label-caps text-on-surface">Legal</span>
<?php foreach ($FOOTER_LEGAL as $link): ?>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-opacity duration-300" href="<?= $link['href'] ?>"><?= $link['label'] ?></a>
<?php endforeach; ?>
</div>
</div>
<div class="md:col-span-1 flex flex-col gap-4">
<span class="font-label-caps text-label-caps text-on-surface">Stay Connected</span>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Join our newsletter for spiritual insights and exclusive temple experiences.</p>
<?php if ($nlFlash = \App\Support\Flash::pull('newsletter')): ?>
<p class="font-body-md text-sm <?= $nlFlash['type'] === 'error' ? 'text-error' : 'text-primary' ?>"><?= htmlspecialchars($nlFlash['message']) ?></p>
<?php endif; ?>
<form class="relative mt-2" action="newsletter.php" method="post">
<?= \App\Support\Csrf::field() ?>
<input class="w-full bg-surface border-b-2 border-outline-variant focus:border-primary px-0 py-2 font-body-md text-body-md text-on-surface focus:ring-0 transition-colors bg-transparent" name="email" placeholder="Email Address" type="email" required/>
<button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 text-primary hover:text-surface-tint" aria-label="Subscribe">
<span class="material-symbols-outlined">arrow_forward</span>
</button>
</form>
</div>
<div class="md:col-span-4 mt-8 pt-8 border-t border-outline-variant/50 flex flex-col md:flex-row justify-between items-center gap-4">
<p class="font-body-md text-body-md text-on-surface-variant text-sm">&copy; <?= date('Y') ?> <?= SITE_NAME ?> Spiritual Services. All rights reserved.</p>
</div>
</div>
</footer>
<script src="assets/js/main.js"></script>
<?php foreach ($pageScripts as $script): ?>
<script src="<?= htmlspecialchars($script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
