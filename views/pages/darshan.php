<?php
/**
 * Darshan page view — content only. Data from public/darshan.php:
 *   $offerings (rows), $category (active key), $hasMore, $nextShow, $total.
 */

use App\Models\DarshanOffering;

/** Build a darshan.php URL (anchored to the offerings section), dropping empties. */
$darshanUrl = static function (array $params): string {
    $query = http_build_query(array_filter($params, static fn ($v) => $v !== null && $v !== '' && $v !== 'all'));
    return 'darshan.php' . ($query !== '' ? '?' . $query : '') . '#offerings';
};
/** category => [badge label, badge classes] for the card ribbon. */
$badge = [
    'daily-darshan' => ['Daily Darshan', 'bg-primary text-on-primary'],
    'special-arati' => ['Special Arati', 'bg-tertiary text-on-tertiary'],
    'vip-darshan'   => ['VIP Darshan', 'bg-secondary text-on-secondary'],
    'festivals'     => ['Festivals', 'bg-secondary-container text-on-secondary-container'],
];
?>
<main class="flex-grow">
<!-- Hero Section -->
<section class="relative pt-32 pb-section md:pt-48 md:pb-32 overflow-hidden bg-surface-container-lowest">
<div class="absolute inset-0 hero-texture opacity-30"></div>
<div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary-container/20 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3"></div>
<div class="absolute bottom-0 left-0 w-[800px] h-[800px] bg-secondary-container/10 rounded-full blur-[100px] translate-y-1/3 -translate-x-1/4"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center">
<div class="lg:col-span-6 space-y-stack-sm text-center lg:text-left">
<div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container border border-outline-variant/30">
<span class="material-symbols-outlined text-primary text-sm">auto_awesome</span>
<span class="font-label-caps text-label-caps text-primary tracking-widest uppercase">Sacred Experiences</span>
</div>
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface">
                        Live Divine <span class="text-primary italic font-light">Presence</span>
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto lg:mx-0">
                        Connect with the divine from anywhere. Book exclusive darshan experiences, participate in daily rituals, and immerse yourself in spiritual tranquility.
                    </p>
<div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start pt-4">
<a href="booking.php" class="w-full sm:w-auto text-center bg-primary text-on-primary font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-tint transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Book Darshan Now
                        </a>
<a href="#offerings" class="w-full sm:w-auto text-center bg-transparent border border-outline text-on-surface font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-container transition-all">
                            View Schedule
                        </a>
</div>
</div>
<!-- Hero Imagery / Bento Style -->
<div class="lg:col-span-6 mt-stack-md lg:mt-0 relative">
<div class="grid grid-cols-2 gap-4 h-[500px]">
<div class="col-span-1 rounded-3xl overflow-hidden shadow-2xl relative" style="transform: translateY(20px);">
<img alt="Sacred temple architecture" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3PjlmVzch6NCytgYdJnxnF-vvI2i4vMonOmUu0eFASX1MBeh56xXvieXDnffbpruIygd2Hzh6MAlbqb6xZyM_N0bUjiwGnqF06O-l6Y988exfS3dx5lMpenpadCwdfNOcbZqsle1y63rdYqwJybbL16fpWTmjG_7EyxLp17teiCAcRMX-E48rwxXMdxU6TTIcyBKixMB4JW0ljr6wD5aQM9agoOkXjavwDRU0mAeuNyoFcIn4uaHEQUtmor9P2SHmcWqMIVkXPBY"/>
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/80 to-transparent flex items-end p-6">
<span class="font-label-caps text-label-caps text-on-primary">Morning Arati</span>
</div>
</div>
<div class="col-span-1 grid grid-rows-2 gap-4">
<div class="row-span-1 rounded-3xl overflow-hidden shadow-xl relative">
<img alt="Offering flowers" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuChIFb4lVGKYElF4iyA9wi80zpncKIun38WeMgFZv6q3K0L6ksi80IcVrLm_v1BRIpw7QSJhCc2mIQTRly7CDUU2IUn1OJjVUU8je77EuvB15gpOwgQxTCTp3TMDD5g-14LrqNwo0VaJpESLFN8NrX-5yvekL-xsLEJ6XRc9hdMLbxIpBcY8LXwxJ96o_3AOhEI7JvFu7RTREBDmAfL8PrnXgY5wLDOr9nh5f_c2phoFn1Z6r-NofL3TrSGEXNfMDr0eQcsacCg8FI"/>
</div>
<div class="row-span-1 rounded-3xl overflow-hidden glass-panel flex flex-col justify-center items-center p-6 text-center">
<span class="material-symbols-outlined text-primary text-4xl mb-2">temple_hindu</span>
<h3 class="font-headline-sm text-headline-sm text-on-surface mb-1">50+</h3>
<p class="font-label-caps text-label-caps text-on-surface-variant">Sacred Temples</p>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Category Filter Tabs -->
<section class="py-stack-sm border-y border-outline-variant/30 bg-surface sticky top-[72px] z-40">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop overflow-x-auto scrollbar-hide">
<div class="flex items-center gap-4 min-w-max">
<?php foreach (DarshanOffering::CATEGORIES as $key => $label): ?>
    <?php $isActive = $key === $category; ?>
<a href="<?= htmlspecialchars($darshanUrl(['category' => $key])) ?>" class="font-label-caps text-label-caps px-6 py-3 rounded-full transition-colors whitespace-nowrap <?= $isActive ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container border border-outline-variant/50 text-on-surface hover:bg-surface-container-high' ?>"><?= htmlspecialchars($label) ?></a>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Darshan Offerings Grid -->
<section id="offerings" class="py-section bg-surface-container-lowest relative">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex justify-between items-end mb-stack-md">
<div>
<h2 class="font-headline-md text-headline-md text-on-surface mb-2">Sacred Offerings</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Select a temple and time for your spiritual connection.</p>
</div>
</div>
<?php if ($offerings === []): ?>
<div class="text-center py-stack-lg">
<span class="material-symbols-outlined text-on-surface-variant text-5xl mb-4">event_busy</span>
<p class="font-body-lg text-body-lg text-on-surface-variant">No offerings in this category yet. Try another tab.</p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
<?php foreach ($offerings as $o): ?>
    <?php
    [$badgeLabel, $badgeClass] = $badge[$o['category']] ?? [$o['category'], 'bg-primary text-on-primary'];
    $schedule = json_decode((string) $o['schedule'], true) ?: [];
    ?>
<div class="glass-panel rounded-3xl overflow-hidden group hover:-translate-y-1 transition-transform duration-300 ambient-shadow flex flex-col">
<div class="h-48 relative overflow-hidden">
<img alt="<?= htmlspecialchars($o['temple_name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= htmlspecialchars($o['image_url']) ?>"/>
<div class="absolute top-4 right-4 bg-surface/90 backdrop-blur-sm px-3 py-1 rounded-full flex items-center gap-1">
<span class="material-symbols-outlined text-primary text-xs fill">star</span>
<span class="font-label-caps text-label-caps text-on-surface text-[10px]"><?= htmlspecialchars(number_format((float) $o['rating'], 1)) ?></span>
</div>
<div class="absolute bottom-4 left-4 <?= $badgeClass ?> px-3 py-1 rounded-full font-label-caps text-label-caps text-[10px]"><?= htmlspecialchars($badgeLabel) ?></div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h3 class="font-headline-sm text-headline-sm text-on-surface mb-1"><?= htmlspecialchars($o['temple_name']) ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 flex items-center gap-1">
<span class="material-symbols-outlined text-sm">location_on</span> <?= htmlspecialchars($o['location']) ?>
                        </p>
<div class="space-y-3 mb-6 flex-grow">
<?php foreach ($schedule as $slot): ?>
<div class="flex justify-between items-center py-2 border-b border-outline-variant/30">
<span class="font-body-md text-body-md text-on-surface"><?= htmlspecialchars($slot['name']) ?></span>
<span class="font-label-caps text-label-caps text-primary"><?= htmlspecialchars($slot['time']) ?></span>
</div>
<?php endforeach; ?>
</div>
<a href="booking.php?offering=<?= urlencode($o['slug']) ?>" class="w-full bg-surface-container border border-outline-variant text-on-surface font-label-caps text-label-caps py-3 rounded-xl hover:border-primary hover:text-primary transition-colors flex justify-center items-center gap-2">
                            Check Availability <span class="material-symbols-outlined text-sm">arrow_forward</span>
</a>
</div>
</div>
<?php endforeach; ?>
</div>
<?php if ($hasMore): ?>
<div class="mt-stack-lg text-center">
<a href="<?= htmlspecialchars($darshanUrl(['category' => $category, 'show' => $nextShow])) ?>" class="bg-transparent border-2 border-primary text-primary font-label-caps text-label-caps px-8 py-3 rounded-full hover:bg-primary/5 transition-colors inline-flex items-center gap-2">
                    Load More Temples <span class="material-symbols-outlined">expand_more</span>
</a>
</div>
<?php endif; ?>
<?php endif; ?>
</div>
</section>
<!-- Reviews & CTA Section (static) -->
<section class="py-section bg-surface relative overflow-hidden">
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-container/10 rounded-full blur-[100px] -z-10"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-stack-lg items-center">
<div class="lg:col-span-5 text-center lg:text-left space-y-6">
<h2 class="font-display-lg-mobile md:font-headline-md text-display-lg-mobile md:text-headline-md text-on-surface">
                        Experience the Divine <br/><span class="text-primary italic font-light">Without Boundaries</span>
</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant">
                        Join thousands of devotees who have found peace and spiritual connection through our curated darshan experiences. Book your slot today.
                    </p>
<div class="pt-4">
<a href="booking.php" class="inline-block bg-primary text-on-primary font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-tint transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg">
                            Start Your Journey
                        </a>
</div>
</div>
<div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-4">
<div class="glass-panel p-6 rounded-3xl ambient-shadow space-y-4 relative md:translate-y-8">
<span class="material-symbols-outlined text-primary/30 text-4xl absolute top-4 right-4">format_quote</span>
<div class="flex text-secondary-container">
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
</div>
<p class="font-body-md text-body-md text-on-surface italic">"The VIP Darshan experience was incredibly seamless. Feeling the divine presence without the rush brought me immense peace."</p>
<div class="flex items-center gap-3 pt-2">
<div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center font-headline-sm text-primary">A</div>
<div>
<h4 class="font-label-caps text-label-caps text-on-surface">Ananya S.</h4>
<p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Verified Devotee</p>
</div>
</div>
</div>
<div class="glass-panel p-6 rounded-3xl ambient-shadow space-y-4 relative">
<span class="material-symbols-outlined text-primary/30 text-4xl absolute top-4 right-4">format_quote</span>
<div class="flex text-secondary-container">
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
<span class="material-symbols-outlined fill text-sm">star</span>
</div>
<p class="font-body-md text-body-md text-on-surface italic">"Booking the morning Arati from miles away made me feel connected to my roots. The high-quality stream and dedicated service are unmatched."</p>
<div class="flex items-center gap-3 pt-2">
<div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center font-headline-sm text-primary">R</div>
<div>
<h4 class="font-label-caps text-label-caps text-on-surface">Rajiv M.</h4>
<p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Verified Devotee</p>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
</main>
