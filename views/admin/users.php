<?php
/** Admin users. Data: $users (array of rows). */
use App\Support\Auth;
use App\Support\Csrf;

$meId = Auth::id();
?>
<p class="font-body-md text-body-md text-on-surface-variant mb-6"><?= count($users) ?> user(s)</p>

<div class="glass-panel ambient-shadow rounded-2xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant bg-surface-container/50">
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Name</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Email</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Joined</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant">Role</th>
<th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($users as $u): $isAdmin = (bool) $u['is_admin']; ?>
<tr class="border-b border-outline-variant/50 hover:bg-surface-container/30">
<td class="px-4 py-3 font-body-md text-body-md text-on-surface font-semibold">
<?= htmlspecialchars($u['name']) ?>
<?php if ((int) $u['id'] === $meId): ?><span class="ml-1 font-label-caps text-label-caps text-on-surface-variant">(you)</span><?php endif; ?>
</td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant"><?= htmlspecialchars($u['email']) ?></td>
<td class="px-4 py-3 font-body-md text-sm text-on-surface-variant whitespace-nowrap"><?= htmlspecialchars(date('d M Y', strtotime((string) $u['created_at']))) ?></td>
<td class="px-4 py-3">
<?php if ($isAdmin): ?>
<span class="font-label-caps text-label-caps bg-primary text-on-primary px-3 py-1 rounded-full">Admin</span>
<?php else: ?>
<span class="font-label-caps text-label-caps bg-surface-container px-3 py-1 rounded-full">User</span>
<?php endif; ?>
</td>
<td class="px-4 py-3">
<div class="flex justify-end">
<?php if ((int) $u['id'] === $meId): ?>
<span class="font-label-caps text-label-caps text-on-surface-variant">—</span>
<?php else: ?>
<form method="POST" action="users.php">
<?= Csrf::field() ?>
<input type="hidden" name="action" value="toggle-admin"/>
<input type="hidden" name="id" value="<?= (int) $u['id'] ?>"/>
<input type="hidden" name="make" value="<?= $isAdmin ? '0' : '1' ?>"/>
<button type="submit" class="font-label-caps text-label-caps px-4 py-2 rounded-full transition-colors <?= $isAdmin ? 'text-error hover:bg-error-container' : 'text-primary hover:bg-surface-container' ?>">
<?= $isAdmin ? 'Revoke admin' : 'Make admin' ?>
</button>
</form>
<?php endif; ?>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
