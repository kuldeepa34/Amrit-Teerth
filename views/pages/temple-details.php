<?php
/**
 * Temple details view — content only. $temple is the row (or null = not found).
 */

use App\Models\Temple;

$categoryLabel = $temple !== null ? (Temple::CATEGORIES[$temple['category']] ?? 'Sacred Temple') : '';
?>
<main class="flex-grow pt-24 md:pt-32 pb-stack-lg min-h-screen">
<?php if ($temple === null): ?>
<!-- Not found -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-lg text-center">
<span class="material-symbols-outlined text-primary text-6xl mb-6">temple_hindu</span>
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-4">Temple Not Found</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto mb-8">We couldn't find the temple you're looking for. It may have moved or no longer exists.</p>
<a href="temples.php" class="inline-flex items-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-full font-label-caps text-label-caps hover:bg-surface-tint transition-colors">
<span class="material-symbols-outlined text-[18px]">arrow_back</span> Browse All Temples
</a>
</section>
<?php else: ?>
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<!-- Breadcrumb -->
<nav class="mb-8 flex items-center gap-2 font-label-caps text-label-caps text-on-surface-variant">
<a href="temples.php" class="hover:text-primary transition-colors">Temples</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-on-surface"><?= htmlspecialchars($temple['name']) ?></span>
</nav>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
<!-- Image -->
<div class="lg:col-span-7 relative h-[360px] md:h-[520px] rounded-3xl overflow-hidden ambient-shadow">
<img alt="<?= htmlspecialchars($temple['name']) ?>" class="w-full h-full object-cover" src="<?= htmlspecialchars($temple['image_url']) ?>"/>
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/40 to-transparent"></div>
<span class="absolute top-4 left-4 bg-surface-container/80 backdrop-blur px-4 py-2 rounded-full font-label-caps text-label-caps text-on-surface"><?= htmlspecialchars($categoryLabel) ?></span>
</div>
<!-- Info -->
<div class="lg:col-span-5 flex flex-col gap-6">
<div class="flex items-center gap-2 text-secondary">
<span class="material-symbols-outlined fill">star</span>
<span class="font-label-caps text-label-caps text-on-surface"><?= htmlspecialchars(number_format((float) $temple['rating'], 1)) ?> Rating</span>
</div>
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary"><?= htmlspecialchars($temple['name']) ?></h1>
<div class="flex flex-col gap-3 font-body-md text-body-md text-on-surface-variant">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary">location_on</span> <?= htmlspecialchars($temple['location']) ?>
</div>
<?php if (!empty($temple['deity'])): ?>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary">auto_awesome</span> Presiding deity: <?= htmlspecialchars($temple['deity']) ?>
</div>
<?php endif; ?>
</div>
<p class="font-body-lg text-body-lg text-on-surface-variant"><?= htmlspecialchars($temple['description']) ?></p>
<div class="flex flex-col sm:flex-row gap-4 pt-2">
<a href="darshan.php" class="text-center bg-primary text-on-primary px-8 py-4 rounded-full font-label-caps text-label-caps hover:bg-surface-tint transition-colors shadow-md">Book Darshan</a>
<a href="services.php" class="text-center border border-outline text-on-surface px-8 py-4 rounded-full font-label-caps text-label-caps hover:bg-surface-container transition-colors">Explore Services</a>
</div>
</div>
</div>
</section>
<?php endif; ?>
</main>
