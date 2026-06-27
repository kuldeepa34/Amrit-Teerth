<?php
/** Admin bookings. Data: $bookings (array of rows joined with user). */
use App\Support\Csrf;
?>
<p class="font-body-md text-body-md text-on-surface-variant mb-6"><?= count($bookings) ?> booking(s)</p>

<?php if ($bookings === []): ?>
<div class="glass-panel rounded-2xl p-10 text-center text-on-surface-variant">No bookings yet.</div>
<?php else: ?>
<div class="glass-panel ambient-shadow rounded-2xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant bg-surface-container/50">
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Devotee</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Offering</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Slot</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Date</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Guests</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Status</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($bookings as $b): ?>
<tr class="border-b border-outline-variant/50 hover:bg-surface-container/30">
<td class="px-4 py-3">
<div class="font-body-md text-body-md text-on-surface font-semibold"><?= htmlspecialchars((string) ($b['user_name'] ?? '—')) ?></div>
<div class="font-label-caps text-label-caps text-on-surface-variant"><?= htmlspecialchars((string) ($b['user_email'] ?? '')) ?></div>
</td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface"><?= htmlspecialchars($b['offering_name']) ?></td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant whitespace-nowrap"><?= htmlspecialchars($b['slot_name']) ?> <span class="text-on-surface"><?= htmlspecialchars($b['slot_time']) ?></span></td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant whitespace-nowrap"><?= htmlspecialchars(date('d M Y', strtotime((string) $b['booking_date']))) ?></td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant"><?= (int) $b['devotees'] ?></td>
<td class="px-4 py-3"><span class="font-label-caps text-label-caps bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full"><?= htmlspecialchars($b['status']) ?></span></td>
<td class="px-4 py-3">
<div class="flex justify-end">
<form method="POST" action="bookings.php" onsubmit="return confirm('Delete this booking?');">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="delete"/>
<input type="hidden" name="id" value="<?= (int) $b['id'] ?>"/>
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
