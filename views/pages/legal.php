<?php
/**
 * Reusable "legal / informational" page view — content only.
 * Rendered inside includes/layout.php.
 *
 * Entry files set, before requiring the layout:
 *   $legalTitle    – page heading (string)
 *   $legalLead     – short intro paragraph (string, optional)
 *   $legalUpdated  – "last updated" date (string, optional)
 *   $legalSections – array of ['heading' => string, 'body' => string[]]
 */
$legalTitle    = $legalTitle    ?? 'Information';
$legalLead     = $legalLead     ?? '';
$legalUpdated  = $legalUpdated  ?? '';
$legalSections = $legalSections ?? [];
?>
<main class="flex-grow pt-24 md:pt-32 pb-stack-lg">
<section class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-col gap-4 mb-stack-md">
<span class="font-label-caps text-label-caps text-primary bg-surface-container px-4 py-2 rounded-full self-start">Amrit Teerth</span>
<h1 class="font-display-lg text-display-lg text-on-surface"><?= htmlspecialchars($legalTitle) ?></h1>
<?php if ($legalLead !== ''): ?>
<p class="font-body-lg text-body-lg text-on-surface-variant"><?= htmlspecialchars($legalLead) ?></p>
<?php endif; ?>
<?php if ($legalUpdated !== ''): ?>
<p class="font-label-caps text-label-caps text-on-surface-variant">Last updated: <?= htmlspecialchars($legalUpdated) ?></p>
<?php endif; ?>
</div>
<div class="flex flex-col gap-stack-sm">
<?php foreach ($legalSections as $section): ?>
<div class="glass-panel rounded-xl p-6 md:p-8 ambient-shadow">
<h2 class="font-headline-sm text-headline-sm text-on-surface mb-3"><?= htmlspecialchars($section['heading']) ?></h2>
<?php foreach ($section['body'] as $paragraph): ?>
<p class="font-body-md text-body-md text-on-surface-variant mb-3 last:mb-0"><?= htmlspecialchars($paragraph) ?></p>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
</div>
</section>
</main>
