<?php
/** Admin dashboard view. Data: $stats (assoc of counts). */
$cards = [
    ['key' => 'temples',     'label' => 'Temples',         'icon' => 'temple_hindu',      'href' => 'temples.php'],
    ['key' => 'darshan',     'label' => 'Puja / Darshan',  'icon' => 'self_improvement',  'href' => 'darshan.php'],
    ['key' => 'bookings',    'label' => 'Bookings',        'icon' => 'event_available',   'href' => 'bookings.php'],
    ['key' => 'messages',    'label' => 'Messages',        'icon' => 'mail',              'href' => 'messages.php'],
    ['key' => 'subscribers', 'label' => 'Subscribers',     'icon' => 'alternate_email',   'href' => 'subscribers.php'],
    ['key' => 'users',       'label' => 'Users',           'icon' => 'group',             'href' => 'users.php'],
];
?>
<p class="font-body-md text-body-md text-on-surface-variant mb-6">Manage all site content and view submissions from one place.</p>
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
<?php foreach ($cards as $c): ?>
<a href="<?= $c['href'] ?>" class="glass-panel ambient-shadow rounded-2xl p-5 flex items-center gap-4 hover:shadow-lg transition-shadow">
<span class="w-12 h-12 shrink-0 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
<span class="material-symbols-outlined"><?= $c['icon'] ?></span>
</span>
<div>
<div class="font-headline-md text-headline-md text-primary leading-none"><?= (int) ($stats[$c['key']] ?? 0) ?></div>
<div class="font-label-caps text-label-caps text-on-surface-variant mt-1"><?= htmlspecialchars($c['label']) ?></div>
</div>
</a>
<?php endforeach; ?>
</div>
