<?php
/**
 * Blogs page view — content only. Data from public/blogs.php:
 *   $featured (row|null), $posts (rows), $topic (active), $hasMore, $nextShow,
 *   $trending (rows), $topics (rows: category,total).
 */

/** Build a blogs.php URL, dropping empty parts. */
$blogsUrl = static function (array $params): string {
    $query = http_build_query(array_filter($params, static fn ($v) => $v !== null && $v !== ''));
    return 'blogs.php' . ($query !== '' ? '?' . $query : '');
};
/** Format a YYYY-MM-DD date for display. */
$fmtDate = static fn (string $d): string => date('M d, Y', strtotime($d));
?>
<main class="flex-grow max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop w-full pt-24 md:pt-32 pb-stack-lg">
<!-- Page Header -->
<header class="py-stack-md text-center">
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-4">Spiritual Insights</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Explore wisdom, traditions, and the profound beauty of sacred rituals documented by our experts and spiritual guides.</p>
<?php if ($topic !== ''): ?>
<p class="mt-4 font-label-caps text-label-caps text-on-surface-variant">Showing topic: <span class="text-primary"><?= htmlspecialchars($topic) ?></span> · <a href="blogs.php" class="text-primary hover:text-secondary underline">Clear</a></p>
<?php endif; ?>
</header>
<!-- Featured Article (unfiltered view only) -->
<?php if ($featured !== null): ?>
<a href="blog-post.php?slug=<?= urlencode($featured['slug']) ?>" class="block mb-stack-lg relative rounded-3xl overflow-hidden glass-panel ambient-shadow group cursor-pointer">
<div class="absolute inset-0 bg-inverse-surface/10 z-10 transition-opacity group-hover:opacity-0"></div>
<div class="h-[614px] md:h-[716px] w-full bg-surface-container relative">
<img alt="<?= htmlspecialchars($featured['title']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= htmlspecialchars($featured['image_url']) ?>"/>
</div>
<div class="absolute bottom-0 left-0 w-full p-8 md:p-12 z-20 bg-gradient-to-t from-inverse-surface/90 via-inverse-surface/50 to-transparent">
<span class="inline-block px-4 py-2 rounded-full bg-surface-container/20 backdrop-blur-md font-label-caps text-label-caps text-on-primary mb-4 border border-white/20">Featured</span>
<h2 class="font-headline-md text-headline-md text-on-primary mb-4 drop-shadow-md"><?= htmlspecialchars($featured['title']) ?></h2>
<p class="font-body-md text-body-md text-surface max-w-3xl mb-6 drop-shadow-sm hidden md:block"><?= htmlspecialchars($featured['excerpt']) ?></p>
<span class="inline-flex items-center gap-2 font-label-caps text-label-caps text-secondary-fixed group-hover:text-on-primary transition-colors">
                    Read Article <span class="material-symbols-outlined text-sm">arrow_forward</span>
</span>
</div>
</a>
<?php endif; ?>
<!-- Content Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
<!-- Main Articles Feed -->
<div class="lg:col-span-8 space-y-gutter">
<?php if ($posts === []): ?>
<div class="glass-panel ambient-shadow rounded-2xl p-10 text-center">
<span class="material-symbols-outlined text-on-surface-variant text-5xl mb-4">article</span>
<p class="font-body-lg text-body-lg text-on-surface-variant">No articles<?= $topic !== '' ? ' under "' . htmlspecialchars($topic) . '"' : '' ?> yet. Check back soon.</p>
</div>
<?php else: ?>
<?php foreach ($posts as $p): ?>
<article class="glass-panel ambient-shadow rounded-2xl p-6 flex flex-col md:flex-row gap-6 hover:shadow-lg transition-shadow">
<div class="w-full md:w-2/5 aspect-[4/3] rounded-xl overflow-hidden bg-surface-container flex-shrink-0">
<img alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" src="<?= htmlspecialchars($p['image_url']) ?>"/>
</div>
<div class="flex flex-col justify-center">
<div class="mb-3 flex items-center gap-3">
<a href="<?= htmlspecialchars($blogsUrl(['topic' => $p['category']])) ?>" class="px-3 py-1 rounded-full bg-surface-container font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors"><?= htmlspecialchars($p['category']) ?></a>
<span class="font-body-md text-body-md text-on-surface-variant/70 text-sm"><?= htmlspecialchars($fmtDate($p['published_at'])) ?></span>
</div>
<h3 class="font-headline-sm text-headline-sm text-on-surface mb-3 leading-tight"><a href="blog-post.php?slug=<?= urlencode($p['slug']) ?>" class="hover:text-primary transition-colors"><?= htmlspecialchars($p['title']) ?></a></h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 line-clamp-2"><?= htmlspecialchars($p['excerpt']) ?></p>
<a class="mt-auto inline-flex items-center gap-2 font-label-caps text-label-caps text-primary hover:text-secondary transition-colors group" href="blog-post.php?slug=<?= urlencode($p['slug']) ?>">
                            Read More <span class="material-symbols-outlined text-sm transform group-hover:translate-x-1 transition-transform">east</span>
</a>
</div>
</article>
<?php endforeach; ?>
<?php if ($hasMore): ?>
<div class="pt-8 flex justify-center">
<a href="<?= htmlspecialchars($blogsUrl(['topic' => $topic, 'show' => $nextShow])) ?>" class="border-2 border-secondary text-on-surface px-8 py-4 rounded-full font-label-caps text-label-caps hover:bg-surface-container transition-colors">Load More Articles</a>
</div>
<?php endif; ?>
<?php endif; ?>
</div>
<!-- Sidebar -->
<aside class="lg:col-span-4 space-y-stack-sm mt-stack-sm lg:mt-0">
<!-- Trending Articles -->
<?php if ($trending !== []): ?>
<div class="glass-panel ambient-shadow rounded-2xl p-6">
<h4 class="font-headline-sm text-headline-sm text-on-surface mb-6 pb-4 border-b border-outline-variant/30 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">trending_up</span> Trending Now
                    </h4>
<div class="space-y-6">
<?php foreach ($trending as $t): ?>
<a class="group block" href="blog-post.php?slug=<?= urlencode($t['slug']) ?>">
<div class="font-label-caps text-label-caps text-primary mb-1"><?= htmlspecialchars($t['category']) ?></div>
<h5 class="font-body-md text-body-md font-semibold text-on-surface group-hover:text-secondary transition-colors line-clamp-2"><?= htmlspecialchars($t['title']) ?></h5>
</a>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
<!-- Newsletter Signup -->
<div class="bg-surface-container-high rounded-2xl p-8 relative overflow-hidden text-center">
<div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-2xl"></div>
<div class="absolute -bottom-10 -left-10 w-32 h-32 bg-secondary/10 rounded-full blur-2xl"></div>
<span class="material-symbols-outlined text-4xl text-primary mb-4 relative z-10">mail</span>
<h4 class="font-headline-sm text-headline-sm text-on-surface mb-2 relative z-10">Receive Spiritual Insights</h4>
<p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm relative z-10">Join our newsletter for weekly articles, exclusive service offers, and guided meditations.</p>
<?php if ($nlFlash = \App\Support\Flash::pull('newsletter')): ?>
<p class="font-body-md text-sm relative z-10 <?= $nlFlash['type'] === 'error' ? 'text-error' : 'text-primary' ?>"><?= htmlspecialchars($nlFlash['message']) ?></p>
<?php endif; ?>
<form class="relative z-10 flex flex-col gap-3" action="newsletter.php" method="post">
<?= \App\Support\Csrf::field() ?>
<input class="w-full bg-surface text-on-surface font-body-md text-body-md px-4 py-3 rounded-lg border-b-2 border-outline focus:border-primary focus:ring-0 transition-colors placeholder:text-on-surface-variant/50" name="email" placeholder="Your email address" type="email" required/>
<button class="w-full bg-primary text-on-primary font-label-caps text-label-caps px-6 py-4 rounded-full hover:bg-surface-tint transition-colors shadow-md" type="submit">Subscribe</button>
</form>
</div>
<!-- Categories / Topics -->
<div class="glass-panel ambient-shadow rounded-2xl p-6">
<h4 class="font-headline-sm text-headline-sm text-on-surface mb-6 pb-4 border-b border-outline-variant/30">Explore Topics</h4>
<div class="flex flex-wrap gap-2">
<?php foreach ($topics as $top): ?>
    <?php $isActive = $top['category'] === $topic; ?>
<a class="px-4 py-2 rounded-full font-label-caps text-label-caps transition-colors <?= $isActive ? 'bg-primary text-on-primary' : 'bg-surface-container text-on-surface-variant hover:bg-primary/10 hover:text-primary' ?>" href="<?= htmlspecialchars($blogsUrl(['topic' => $top['category']])) ?>"><?= htmlspecialchars($top['category']) ?> (<?= (int) $top['total'] ?>)</a>
<?php endforeach; ?>
</div>
</div>
</aside>
</div>
</main>
