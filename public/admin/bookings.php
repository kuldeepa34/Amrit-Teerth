<?php
/**
 * Admin — Darshan bookings (view + delete).
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\Booking;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('admin', 'Security check failed. Please try again.', 'error');
        Http::to('bookings.php');
    }
    if (($_POST['action'] ?? '') === 'delete') {
        Booking::delete((int) ($_POST['id'] ?? 0));
        Flash::set('admin', 'Booking deleted.');
    }
    Http::to('bookings.php');
}

$bookings         = Booking::all();
$pageTitle        = 'Bookings';
$adminPageHeading = 'Darshan Bookings';
$adminNav         = 'bookings';
$contentView      = __DIR__ . '/../../views/admin/bookings.php';

require __DIR__ . '/../../includes/admin_layout.php';
