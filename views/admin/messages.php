<?php
/** Admin contact messages. Data: $messages (array of rows). */
use App\Support\Csrf;
?>
<p class="font-body-md text-body-md text-on-surface-variant mb-6"><?= count($messages) ?> message(s)</p>

<?php if ($messages === []): ?>
<div class="glass-panel rounded-2xl p-10 text-center text-on-surface-variant">No messages yet.</div>
<?php else: ?>
<div class="flex flex-col gap-4">
<?php foreach ($messages as $m): ?>
<div class="glass-panel ambient-shadow rounded-2xl p-5">
<div class="flex items-start justify-between gap-4 flex-wrap">
<div>
<div class="font-body-md text-body-md text-on-surface font-semibold"><?= htmlspecialchars($m['full_name']) ?></div>
<a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="font-label-caps text-label-caps text-primary hover:text-secondary"><?= htmlspecialchars($m['email']) ?></a>
<?php if (!empty($m['service_interest'])): ?>
<span class="ml-2 font-label-caps text-label-caps bg-surface-container px-3 py-1 rounded-full"><?= htmlspecialchars($m['service_interest']) ?></span>
<?php endif; ?>
</div>
<div class="flex items-center gap-3">
<span class="font-label-caps text-label-caps text-on-surface-variant whitespace-nowrap"><?= htmlspecialchars(date('d M Y, H:i', strtotime((string) $m['created_at']))) ?></span>
<form method="POST" action="messages.php" onsubmit="return confirm('Delete this message?');">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="delete"/>
<input type="hidden" name="id" value="<?= (int) $m['id'] ?>"/>
<button type="submit" class="w-9 h-9 flex items-center justify-center rounded-full text-error hover:bg-error-container transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</form>
</div>
</div>
<p class="font-body-md text-body-md text-on-surface-variant mt-3 whitespace-pre-line"><?= htmlspecialchars($m['message']) ?></p>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
