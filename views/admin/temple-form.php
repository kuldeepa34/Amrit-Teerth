<?php
/** Add/edit temple form. Data: $temple (row or null). */
use App\Models\Temple;
use App\Support\Csrf;

$t = $temple ?? [];
$v = static fn (string $k, $default = '') => htmlspecialchars((string) ($t[$k] ?? $default), ENT_QUOTES);
$isEdit = !empty($t['id']);
?>
<a href="temples.php" class="inline-flex items-center gap-1 font-label-caps text-label-caps text-on-surface-variant hover:text-primary mb-6 transition-colors">
<span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to list
</a>
<form method="POST" action="temples.php" class="glass-panel ambient-shadow rounded-2xl p-6 md:p-8 max-w-3xl">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="save"/>
<?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $t['id'] ?>"/><?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Name *</label>
<input name="name" required value="<?= $v('name') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Slug <span class="normal-case opacity-70">(auto from name if blank)</span></label>
<input name="slug" value="<?= $v('slug') ?>" placeholder="e.g. mahakaleshwar" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Deity</label>
<input name="deity" value="<?= $v('deity') ?>" placeholder="e.g. Lord Shiva" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Location *</label>
<input name="location" required value="<?= $v('location') ?>" placeholder="e.g. Ujjain, Madhya Pradesh" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Category</label>
<select name="category" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0">
<?php foreach (Temple::STORABLE_CATEGORIES as $key => $label): ?>
<option value="<?= htmlspecialchars($key) ?>" <?= ($t['category'] ?? 'other') === $key ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Rating (0–5)</label>
<input name="rating" type="number" step="0.1" min="0" max="5" value="<?= $v('rating', '5.0') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2 md:col-span-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Image URL *</label>
<input name="image_url" required value="<?= $v('image_url') ?>" placeholder="https://..." class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2 md:col-span-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Description *</label>
<textarea name="description" required rows="4" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"><?= $v('description') ?></textarea>
</div>
</div>

<div class="flex items-center gap-3 mt-8">
<button type="submit" class="bg-primary text-on-primary font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-tint transition-colors shadow-md"><?= $isEdit ? 'Save Changes' : 'Add Temple' ?></button>
<a href="temples.php" class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary px-4 py-4 transition-colors">Cancel</a>
</div>
</form>
