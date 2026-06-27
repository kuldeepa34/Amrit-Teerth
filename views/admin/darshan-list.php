<?php
/** Admin darshan/puja list. Data: $offerings (array of rows). */
use App\Models\DarshanOffering;
use App\Support\Csrf;
?>
<div class="flex items-center justify-between mb-6">
<p class="font-body-md text-body-md text-on-surface-variant"><?= count($offerings) ?> offering(s)</p>
<a href="darshan.php?action=new" class="inline-flex items-center gap-2 bg-primary text-on-primary font-label-caps text-label-caps px-5 py-3 rounded-full hover:bg-surface-tint transition-colors shadow-sm">
<span class="material-symbols-outlined text-[18px]">add</span> Add Offering
</a>
</div>

<?php if ($offerings === []): ?>
<div class="glass-panel rounded-2xl p-10 text-center text-on-surface-variant">No offerings yet. Click “Add Offering” to create one.</div>
<?php else: ?>
<div class="glass-panel ambient-shadow rounded-2xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant bg-surface-container/50">
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Offering</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Category</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Schedule</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Rating</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($offerings as $o): ?>
<?php
    $slots = json_decode((string) $o['schedule'], true) ?: [];
    $label = DarshanOffering::STORABLE_CATEGORIES[$o['category']] ?? $o['category'];
?>
<tr class="border-b border-outline-variant/50 hover:bg-surface-container/30">
<td class="px-4 py-3">
<div class="flex items-center gap-3">
<img src="<?= htmlspecialchars($o['image_url']) ?>" alt="" class="w-12 h-12 rounded-lg object-cover shrink-0"/>
<div>
<div class="font-body-md text-body-md text-on-surface font-semibold"><?= htmlspecialchars($o['temple_name']) ?></div>
<div class="font-label-caps text-label-caps text-on-surface-variant"><?= htmlspecialchars($o['location']) ?></div>
</div>
</div>
</td>
<td class="px-4 py-3"><span class="font-label-caps text-label-caps bg-surface-container px-3 py-1 rounded-full whitespace-nowrap"><?= htmlspecialchars($label) ?></span></td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant">
<?php foreach ($slots as $s): ?>
<div class="whitespace-nowrap"><?= htmlspecialchars($s['name'] ?? '') ?> — <span class="text-on-surface"><?= htmlspecialchars($s['time'] ?? '') ?></span></div>
<?php endforeach; ?>
</td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant"><?= htmlspecialchars(number_format((float) $o['rating'], 1)) ?></td>
<td class="px-4 py-3">
<div class="flex items-center justify-end gap-1">
<a href="darshan.php?action=edit&id=<?= (int) $o['id'] ?>" class="w-9 h-9 flex items-center justify-center rounded-full text-primary hover:bg-surface-container transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]">edit</span>
</a>
<form method="POST" action="darshan.php" onsubmit="return confirm('Delete this offering?');" class="inline">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="delete"/>
<input type="hidden" name="id" value="<?= (int) $o['id'] ?>"/>
<button type="submit" class="w-9 h-9 flex items-center justify-center rounded-full text-error hover:bg-error-container transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</form>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
<?php endif; ?>
