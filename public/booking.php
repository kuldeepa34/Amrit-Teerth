<?php
/**
 * Booking — pick a darshan offering, date, slot & devotees. Login required.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;
use App\Models\DarshanOffering;
use App\Models\Booking;

// --- Require login (remember where we were headed) ---
if (!Auth::check()) {
    $slugParam = isset($_GET['offering']) ? '?offering=' . urlencode((string) $_GET['offering']) : '';
    $_SESSION['intended_url'] = 'booking.php' . $slugParam;
    Flash::set('auth', 'Please sign in to book your darshan.', 'error');
    Http::to('login.php');
}

$offerings = DarshanOffering::all();

// --- Handle submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('booking', 'Security check failed. Please try again.', 'error');
        Http::to('booking.php');
    }

    $offeringId = (int) ($_POST['offering_id'] ?? 0);
    $slotIndex  = (int) ($_POST['slot'] ?? -1);
    $date       = trim((string) ($_POST['date'] ?? ''));
    $devotees   = (int) ($_POST['devotees'] ?? 1);

    $offering = DarshanOffering::find($offeringId);
    $schedule = $offering !== null ? (json_decode((string) $offering['schedule'], true) ?: []) : [];

    $errors = [];
    if ($offering === null) {
        $errors[] = 'a valid temple';
    }
    if (!isset($schedule[$slotIndex])) {
        $errors[] = 'a time slot';
    }
    $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
    $today   = new \DateTime('today');
    if ($dateObj === false || $dateObj < $today) {
        $errors[] = 'a date today or later';
    }
    if ($devotees < 1 || $devotees > 10) {
        $errors[] = 'between 1 and 10 devotees';
    }

    if ($errors !== []) {
        Flash::set('booking', 'Please select ' . implode(', ', $errors) . '.', 'error');
        Http::to('booking.php' . ($offering !== null ? '?offering=' . urlencode($offering['slug']) : ''));
    }

    $slot = $schedule[$slotIndex];

    // Block accidental double-booking of the same offering/date/slot.
    if (Booking::existsForSlot((int) Auth::id(), (int) $offering['id'], $dateObj->format('Y-m-d'), (string) $slot['name'])) {
        Flash::set('booking', 'You already have a booking for this slot on that date. 🙏', 'error');
        Http::to('booking.php?offering=' . urlencode($offering['slug']));
    }

    Booking::create(
        (int) Auth::id(),
        (int) $offering['id'],
        $offering['temple_name'],
        (string) $slot['name'],
        (string) $slot['time'],
        $dateObj->format('Y-m-d'),
        $devotees
    );

    Flash::set(
        'booking',
        'Your darshan at ' . $offering['temple_name'] . ' (' . $slot['name'] . ', ' . $slot['time'] . ') on '
            . $dateObj->format('M d, Y') . ' is confirmed. 🙏',
        'success'
    );
    Http::to('booking.php');
}

// --- GET: prepare the form ---
$selectedSlug  = trim((string) ($_GET['offering'] ?? ''));
$selected      = $selectedSlug !== '' ? DarshanOffering::findBySlug($selectedSlug) : null;
$selectedId    = $selected['id'] ?? ($offerings[0]['id'] ?? 0);

// Map of offering id => schedule array, for the live slot dropdown (JS).
$scheduleMap = [];
foreach ($offerings as $o) {
    $scheduleMap[(int) $o['id']] = json_decode((string) $o['schedule'], true) ?: [];
}

$myBookings = Booking::forUser((int) Auth::id(), 5);

$pageTitle   = 'Book Darshan - ' . SITE_NAME;
$activeNav   = 'darshan';
$pageScripts = ['assets/js/booking.js'];
$contentView = __DIR__ . '/../views/pages/booking.php';

require __DIR__ . '/../includes/layout.php';
