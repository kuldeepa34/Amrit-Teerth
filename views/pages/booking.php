<?php
/**
 * Booking page view — content only. Data from public/booking.php:
 *   $offerings, $selectedId, $scheduleMap (id=>slots), $myBookings.
 */

$selectedSchedule = $scheduleMap[$selectedId] ?? [];
$today = date('Y-m-d');
?>
<main class="flex-grow pt-24 md:pt-32 pb-stack-lg min-h-screen">
<section class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop">
<div class="text-center mb-stack-md">
<span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container border border-outline-variant/30 mb-4">
<span class="material-symbols-outlined text-primary text-sm">event_available</span>
<span class="font-label-caps text-label-caps text-primary tracking-widest uppercase">Reserve Your Slot</span>
</span>
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-3">Book Your Darshan</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">Choose a temple, date and time. We'll handle the rest.</p>
</div>

<?php if ($bookingFlash = \App\Support\Flash::pull('booking')): ?>
<div class="mb-8 rounded-2xl px-6 py-5 font-body-md text-body-md flex items-start gap-3 <?= $bookingFlash['type'] === 'error' ? 'bg-error-container text-on-error-container' : 'bg-secondary-container text-on-secondary-container' ?>">
<span class="material-symbols-outlined"><?= $bookingFlash['type'] === 'error' ? 'error' : 'check_circle' ?></span>
<span><?= htmlspecialchars($bookingFlash['message']) ?></span>
</div>
<?php endif; ?>

<?php if ($offerings === []): ?>
<div class="glass-panel ambient-shadow rounded-3xl p-10 text-center">
<p class="font-body-lg text-body-lg text-on-surface-variant">No darshan offerings are available right now. Please check back soon.</p>
</div>
<?php else: ?>
<!-- Booking form -->
<div class="glass-panel ambient-shadow rounded-3xl p-6 md:p-10">
<form method="POST" action="booking.php" class="space-y-6">
<?= \App\Support\Csrf::field() ?>
<div class="flex flex-col gap-2">
<label for="offering" class="font-label-caps text-label-caps text-on-surface-variant">Temple / Experience</label>
<select id="offering" name="offering_id" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors">
<?php foreach ($offerings as $o): ?>
<option value="<?= (int) $o['id'] ?>" <?= (int) $o['id'] === (int) $selectedId ? 'selected' : '' ?>><?= htmlspecialchars($o['temple_name']) ?> — <?= htmlspecialchars($o['location']) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
<div class="flex flex-col gap-2">
<label for="date" class="font-label-caps text-label-caps text-on-surface-variant">Date</label>
<input id="date" name="date" type="date" required min="<?= $today ?>" value="<?= $today ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors"/>
</div>
<div class="flex flex-col gap-2">
<label for="slot" class="font-label-caps text-label-caps text-on-surface-variant">Time Slot</label>
<select id="slot" name="slot" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors">
<?php foreach ($selectedSchedule as $i => $slot): ?>
<option value="<?= (int) $i ?>"><?= htmlspecialchars($slot['name']) ?> — <?= htmlspecialchars($slot['time']) ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
<div class="flex flex-col gap-2">
<label for="devotees" class="font-label-caps text-label-caps text-on-surface-variant">Number of Devotees</label>
<input id="devotees" name="devotees" type="number" min="1" max="10" value="1" required class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors"/>
</div>
<button type="submit" class="w-full bg-primary text-on-primary font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-tint transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    Confirm Booking <span class="material-symbols-outlined text-[18px]">check</span>
</button>
</form>
</div>
<?php endif; ?>

<!-- Recent bookings -->
<?php if ($myBookings !== []): ?>
<div class="mt-stack-lg">
<h2 class="font-headline-sm text-headline-sm text-on-surface mb-6">Your Recent Bookings</h2>
<div class="space-y-4">
<?php foreach ($myBookings as $b): ?>
<div class="glass-panel ambient-shadow rounded-2xl p-5 flex items-center justify-between gap-4">
<div>
<h3 class="font-headline-sm text-body-lg text-on-surface"><?= htmlspecialchars($b['offering_name']) ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">
<?= htmlspecialchars($b['slot_name']) ?> · <?= htmlspecialchars($b['slot_time']) ?> ·
                            <?= htmlspecialchars(date('M d, Y', strtotime($b['booking_date']))) ?> ·
                            <?= (int) $b['devotees'] ?> devotee<?= (int) $b['devotees'] > 1 ? 's' : '' ?>
</p>
</div>
<span class="font-label-caps text-label-caps px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container capitalize"><?= htmlspecialchars($b['status']) ?></span>
</div>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</section>
</main>
<script>
    window.__offeringSchedules = <?= json_encode($scheduleMap, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>
