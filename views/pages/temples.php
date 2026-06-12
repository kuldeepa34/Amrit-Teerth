<?php
/**
 * Temples page view — content only. Data provided by public/temples.php:
 *   $temples (array rows), $category (active key), $search (string),
 *   $hasMore (bool), $nextShow (int), $total (int).
 */

use App\Models\Temple;

/** Build a temples.php URL preserving the relevant query parts. */
$templesUrl = static function (array $params): string {
    $query = http_build_query(array_filter($params, static fn ($v) => $v !== null && $v !== '' && $v !== 'all'));
    return 'temples.php' . ($query !== '' ? '?' . $query : '');
};
?>
<main class="flex-grow pt-24 md:pt-32 pb-stack-lg min-h-screen">
<!-- Search & Filter Section -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-md">
<div class="text-center mb-12">
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-4">Discover Sacred Temples</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Explore ancient sanctuaries and modern marvels of spiritual devotion.</p>
</div>
<div class="glass-panel ambient-shadow rounded-xl p-4 md:p-6 mb-stack-md flex flex-col md:flex-row gap-4 items-center">
<form method="get" action="temples.php" class="relative flex-grow w-full">
<?php if ($category !== 'all'): ?><input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>"/><?php endif; ?>
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
<input name="q" value="<?= htmlspecialchars($search) ?>" class="w-full bg-surface-container-lowest border-0 border-b-2 border-outline focus:border-primary focus:ring-0 pl-12 py-4 font-body-md text-body-md text-on-surface transition-colors placeholder:text-on-surface-variant/50" placeholder="Search temples by name or deity..." type="text"/>
</form>
<div class="flex gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-hide">
<?php foreach (Temple::CATEGORIES as $key => $label): ?>
    <?php $isActive = $key === $category; ?>
<a href="<?= htmlspecialchars($templesUrl(['category' => $key, 'q' => $search])) ?>" class="whitespace-nowrap px-6 py-2 rounded-full font-label-caps text-label-caps transition-colors <?= $isActive ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container hover:bg-surface-container-high text-on-surface' ?>"><?= htmlspecialchars($label) ?></a>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Temple Grid -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mb-stack-lg">
<?php if ($temples === []): ?>
<div class="text-center py-stack-lg">
<span class="material-symbols-outlined text-on-surface-variant text-5xl mb-4">search_off</span>
<p class="font-body-lg text-body-lg text-on-surface-variant">No temples found<?= $search !== '' ? ' for "' . htmlspecialchars($search) . '"' : '' ?>. Try a different search or filter.</p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
<?php foreach ($temples as $t): ?>
<div class="glass-panel ambient-shadow rounded-xl overflow-hidden group flex flex-col">
<div class="h-64 overflow-hidden relative">
<img alt="<?= htmlspecialchars($t['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= htmlspecialchars($t['image_url']) ?>"/>
<div class="absolute top-4 right-4 bg-surface-container/80 backdrop-blur px-3 py-1 rounded-full flex items-center gap-1">
<span class="material-symbols-outlined text-[16px] text-secondary fill">star</span>
<span class="font-label-caps text-label-caps text-on-surface"><?= htmlspecialchars(number_format((float) $t['rating'], 1)) ?></span>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<div class="flex items-center gap-2 mb-2 text-on-surface-variant">
<span class="material-symbols-outlined text-[18px]">location_on</span>
<span class="font-label-caps text-label-caps"><?= htmlspecialchars($t['location']) ?></span>
</div>
<h3 class="font-headline-sm text-headline-sm text-primary mb-3"><?= htmlspecialchars($t['name']) ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-3"><?= htmlspecialchars($t['description']) ?></p>
<div class="mt-auto pt-4 border-t border-outline-variant">
<a href="temple-details.php?temple=<?= urlencode($t['slug']) ?>" class="block text-center w-full py-3 font-label-caps text-label-caps text-primary border border-outline rounded hover:bg-surface-container transition-colors group-hover:bg-primary group-hover:text-on-primary group-hover:border-primary">View Details</a>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php if ($hasMore): ?>
<div class="mt-12 text-center">
<a href="<?= htmlspecialchars($templesUrl(['category' => $category, 'q' => $search, 'show' => $nextShow])) ?>" class="px-8 py-4 bg-surface-container text-primary font-label-caps text-label-caps rounded-full hover:bg-surface-container-high transition-colors shadow-sm inline-flex items-center gap-2">
                    Load More <span class="material-symbols-outlined text-[18px]">expand_more</span>
</a>
</div>
<?php endif; ?>
<?php endif; ?>
</section>
<!-- Popular Destinations (static for now) -->
<section class="bg-surface-container-lowest py-stack-lg border-t border-outline-variant">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex justify-between items-end mb-10">
<div>
<h2 class="font-headline-md text-headline-md text-primary mb-2">Popular Pilgrimage Routes</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Curated spiritual journeys across India.</p>
</div>
<a class="hidden md:inline-flex items-center gap-1 font-label-caps text-label-caps text-secondary hover:text-primary transition-colors" href="services.php#pilgrimage">
                        View All <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-gutter">
<a href="services.php#pilgrimage" class="relative rounded-xl overflow-hidden group aspect-[4/5] cursor-pointer block">
<img alt="Char Dham" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBHvl-_hQYgL-qbIC8yLjmXkWD4Nf52PkxOh5Jr7Wt4qpqmkzMDMyHZEf_v2wfAyneBcVPodG0wEeC5-JFM0AlR22lA7BVWIjmqXgq1-6lySyXAs1K4aW8bsp1PG-SJgVhYFQz1wB0oFDJyYbQrBtZ9Kmoh_8fzT9vbCFbpHiIuKYLhpN6ZKYZaQycoUjv2UakPHel45ozHxk7YT04LUtW35bgNZEOFBSIWbtbr3dZrPMGpS8bPbAgT1KY0nV2cFeq8MN-2vw2H8bM"/>
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/80 via-inverse-surface/20 to-transparent"></div>
<div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
<h4 class="font-headline-sm text-headline-sm text-on-primary mb-1">Char Dham Yatra</h4>
<p class="font-label-caps text-label-caps text-on-primary/80">Uttarakhand</p>
</div>
</a>
<a href="services.php#pilgrimage" class="relative rounded-xl overflow-hidden group aspect-[4/5] cursor-pointer block">
<img alt="Tamil Nadu Temples" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCTMEw2TH6MYIklcO4LOBek8ntNy6HYn-lWVKxTOszC2b1p7ejvRWTomMQNNiwakABRBnjoEuw8n4Sz-d5v4IYwRbCjbh8l73U9rvYOKBM6ExbHHKHNV4W7FsNDT-vZI7wjmToFgbhV6pyOAFYawvLBX_4tTPhi1U_7bD_RqObF2N9-TJ2v97Ho2Uud1G0JdKF1tvVdL3oBYw82Fhv3eq_pYqatYJTnMBvRixgcqPuPtPn0h7uOfUgbjdO7Jg8LxQCxU5r31u8A1LE"/>
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/80 via-inverse-surface/20 to-transparent"></div>
<div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
<h4 class="font-headline-sm text-headline-sm text-on-primary mb-1">Dravidian Circuit</h4>
<p class="font-label-caps text-label-caps text-on-primary/80">Tamil Nadu</p>
</div>
</a>
<a href="services.php#pilgrimage" class="relative rounded-xl overflow-hidden group aspect-[4/5] cursor-pointer block">
<img alt="Odisha Temples" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuChNizIVoBhPIb3VX3NFq8Yc2RI9DAA54mSq-A09pUg2YcdE929T_xBOxIwOCpQIW1DBv4_fAnCb2m4A2q3QUxD21BfD6MobKEvnrcvalBJKHPr4nfeYHO_Azsi-Iks0J6Y_LTupmfh58J6oCHixI1kZFC6lsNUdGFRyp7BOq-hj0SKvMWgaJII71jQvLER5qe6tuDTnl0Y87BYkyEcxr1GRSJ0WPBXhIVYYn9ezUdfwXFmXwLm2Lm071PTkI4MXPRNmbfVadUKCBs"/>
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/80 via-inverse-surface/20 to-transparent"></div>
<div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
<h4 class="font-headline-sm text-headline-sm text-on-primary mb-1">Eastern Triangle</h4>
<p class="font-label-caps text-label-caps text-on-primary/80">Odisha</p>
</div>
</a>
<a href="services.php#pilgrimage" class="relative rounded-xl overflow-hidden group aspect-[4/5] cursor-pointer block">
<img alt="Dwarka" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCiJhwAu0rWUXoNGo7ED2Ka4TzsceQ7hUVRyJUeoXN8i3jeP1VE4Amq_vmRPxW7AvT4vZYpLM5l5VOomEWnn-UJnU-2GJ6voovLBXNWZkQe3Q-ECF1VPKmNRHnG4_xjbIvPERe_RkXma1i0JprfABkCu9qFoQSHeBDIoNKkGqwsTMYUG3GSQvX1KSbEOc4xcdSpAc7EyfFfrYjYVB4uFy2hPNzz3_8lGgJ-LUW_dzQCSwWs0iTekHPg6j4Tohi2HMeKvziMPvDhwX0"/>
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/80 via-inverse-surface/20 to-transparent"></div>
<div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
<h4 class="font-headline-sm text-headline-sm text-on-primary mb-1">Western Shores</h4>
<p class="font-label-caps text-label-caps text-on-primary/80">Gujarat</p>
</div>
</a>
</div>
<a class="md:hidden mt-6 inline-flex items-center justify-center w-full py-3 font-label-caps text-label-caps text-secondary border border-secondary rounded" href="services.php#pilgrimage">
                    View All Routes
                </a>
</div>
</section>
</main>
