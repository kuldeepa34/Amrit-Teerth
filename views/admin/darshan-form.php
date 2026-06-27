<?php
/** Add/edit darshan/puja form. Data: $offering (row or null). */
use App\Models\DarshanOffering;
use App\Support\Csrf;

$o = $offering ?? [];
$v = static fn (string $k, $default = '') => htmlspecialchars((string) ($o[$k] ?? $default), ENT_QUOTES);
$isEdit = !empty($o['id']);
$slots  = $isEdit ? (json_decode((string) $o['schedule'], true) ?: []) : [];
if ($slots === []) {
    $slots = [['name' => '', 'time' => '']]; // start with one blank row
}
?>
<a href="darshan.php" class="inline-flex items-center gap-1 font-label-caps text-label-caps text-on-surface-variant hover:text-primary mb-6 transition-colors">
<span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to list
</a>
<form method="POST" action="darshan.php" class="glass-panel ambient-shadow rounded-2xl p-6 md:p-8 max-w-3xl">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="save"/>
<?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $o['id'] ?>"/><?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Temple Name *</label>
<input name="temple_name" required value="<?= $v('temple_name') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Slug <span class="normal-case opacity-70">(auto if blank)</span></label>
<input name="slug" value="<?= $v('slug') ?>" placeholder="e.g. mahakaleshwar-bhasma" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Location *</label>
<input name="location" required value="<?= $v('location') ?>" placeholder="e.g. Ujjain, Madhya Pradesh" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
</div>
<div class="flex flex-col gap-2">
<label class="font-label-caps text-label-caps text-on-surface-variant">Category</label>
<select name="category" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0">
<?php foreach (DarshanOffering::STORABLE_CATEGORIES as $key => $label): ?>
<option value="<?= htmlspecialchars($key) ?>" <?= ($o['category'] ?? 'daily-darshan') === $key ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
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
</div>

<!-- Schedule -->
<div class="mt-6">
<label class="font-label-caps text-label-caps text-on-surface-variant">Schedule (Aarti / Darshan timings)</label>
<div id="schedule-rows" class="flex flex-col gap-3 mt-3">
<?php foreach ($slots as $s): ?>
<div class="schedule-row flex gap-3 items-center">
<input name="schedule_name[]" value="<?= htmlspecialchars((string) ($s['name'] ?? ''), ENT_QUOTES) ?>" placeholder="Slot name (e.g. Bhasma Arati)" class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
<input name="schedule_time[]" value="<?= htmlspecialchars((string) ($s['time'] ?? ''), ENT_QUOTES) ?>" placeholder="Time (e.g. 04:00 AM)" class="w-40 bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0"/>
<button type="button" class="remove-row w-10 h-10 shrink-0 flex items-center justify-center rounded-full text-error hover:bg-error-container transition-colors" title="Remove">
<span class="material-symbols-outlined text-[20px]">close</span>
</button>
</div>
<?php endforeach; ?>
</div>
<button type="button" id="add-row" class="mt-3 inline-flex items-center gap-1 font-label-caps text-label-caps text-primary hover:text-secondary transition-colors">
<span class="material-symbols-outlined text-[18px]">add</span> Add timing
</button>
</div>

<div class="flex items-center gap-3 mt-8">
<button type="submit" class="bg-primary text-on-primary font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-tint transition-colors shadow-md"><?= $isEdit ? 'Save Changes' : 'Add Offering' ?></button>
<a href="darshan.php" class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary px-4 py-4 transition-colors">Cancel</a>
</div>
</form>
<script>
  (function () {
    var rows = document.getElementById('schedule-rows');
    function bindRemove(btn) {
      btn.addEventListener('click', function () {
        if (rows.querySelectorAll('.schedule-row').length > 1) {
          btn.closest('.schedule-row').remove();
        } else {
          btn.closest('.schedule-row').querySelectorAll('input').forEach(function (i) { i.value = ''; });
        }
      });
    }
    rows.querySelectorAll('.remove-row').forEach(bindRemove);
    document.getElementById('add-row').addEventListener('click', function () {
      var first = rows.querySelector('.schedule-row');
      var clone = first.cloneNode(true);
      clone.querySelectorAll('input').forEach(function (i) { i.value = ''; });
      bindRemove(clone.querySelector('.remove-row'));
      rows.appendChild(clone);
    });
  })();
</script>
