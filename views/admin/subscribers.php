<?php
/** Admin newsletter subscribers. Data: $subscribers (array of rows). */
use App\Support\Csrf;
?>
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
<p class="font-body-md text-body-md text-on-surface-variant"><?= count($subscribers) ?> subscriber(s)</p>
<?php if ($subscribers !== []): ?>
<a href="subscribers.php?export=csv" class="inline-flex items-center gap-2 bg-surface-container text-primary font-label-caps text-label-caps px-5 py-3 rounded-full hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-[18px]">download</span> Export CSV
</a>
<?php endif; ?>
</div>

<?php if ($subscribers === []): ?>
<div class="glass-panel rounded-2xl p-10 text-center text-on-surface-variant">No subscribers yet.</div>
<?php else: ?>
<div class="glass-panel ambient-shadow rounded-2xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant bg-surface-container/50">
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Email</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Subscribed</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($subscribers as $s): ?>
<tr class="border-b border-outline-variant/50 hover:bg-surface-container/30">
<td class="px-4 py-3 font-body-md text-body-md text-on-surface"><?= htmlspecialchars($s['email']) ?></td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant whitespace-nowrap"><?= htmlspecialchars(date('d M Y', strtotime((string) $s['created_at']))) ?></td>
<td class="px-4 py-3">
<div class="flex justify-end">
<form method="POST" action="subscribers.php" onsubmit="return confirm('Remove this subscriber?');">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="delete"/>
<input type="hidden" name="id" value="<?= (int) $s['id'] ?>"/>
<button type="submit" class="w-9 h-9 flex items-center justify-center rounded-full text-error hover:bg-error-container transition-colors" title="Remove">
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
