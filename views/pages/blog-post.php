<?php
/**
 * Single blog post view — content only. $post is the row (or null = not found).
 */
?>
<main class="flex-grow pt-24 md:pt-32 pb-stack-lg min-h-screen">
<?php if ($post === null): ?>
<!-- Not found -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-lg text-center">
<span class="material-symbols-outlined text-primary text-6xl mb-6">article</span>
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-4">Article Not Found</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto mb-8">We couldn't find the article you're looking for. It may have moved or no longer exists.</p>
<a href="blogs.php" class="inline-flex items-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-full font-label-caps text-label-caps hover:bg-surface-tint transition-colors">
<span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to Blogs
</a>
</section>
<?php else: ?>
<article class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop">
<!-- Breadcrumb -->
<nav class="mb-6 flex items-center gap-2 font-label-caps text-label-caps text-on-surface-variant">
<a href="blogs.php" class="hover:text-primary transition-colors">Blogs</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-on-surface line-clamp-1"><?= htmlspecialchars($post['title']) ?></span>
</nav>
<!-- Meta -->
<div class="flex items-center gap-3 mb-4">
<a href="blogs.php?topic=<?= urlencode($post['category']) ?>" class="px-3 py-1 rounded-full bg-surface-container font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors"><?= htmlspecialchars($post['category']) ?></a>
<span class="font-body-md text-body-md text-on-surface-variant/70 text-sm"><?= htmlspecialchars(date('M d, Y', strtotime($post['published_at']))) ?></span>
</div>
<!-- Title + author -->
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-4 leading-tight"><?= htmlspecialchars($post['title']) ?></h1>
<p class="font-body-md text-body-md text-on-surface-variant mb-8">By <span class="text-primary"><?= htmlspecialchars($post['author']) ?></span></p>
<!-- Hero image -->
<div class="rounded-3xl overflow-hidden ambient-shadow mb-stack-md h-[300px] md:h-[460px]">
<img alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover" src="<?= htmlspecialchars($post['image_url']) ?>"/>
</div>
<!-- Body -->
<div class="space-y-6">
<?php foreach (preg_split('/\n\s*\n/', trim($post['body'])) as $paragraph): ?>
<p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed"><?= htmlspecialchars($paragraph) ?></p>
<?php endforeach; ?>
</div>
<!-- Back link -->
<div class="mt-stack-lg pt-8 border-t border-outline-variant/40">
<a href="blogs.php" class="inline-flex items-center gap-2 font-label-caps text-label-caps text-primary hover:text-secondary transition-colors">
<span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to all articles
</a>
</div>
</article>
<?php endif; ?>
</main>
