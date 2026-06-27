<?php
/**
 * Admin dashboard — at-a-glance counts + quick links.
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\Temple;
use App\Models\DarshanOffering;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\User;

$stats = [
    'temples'     => Temple::count_all(),
    'darshan'     => DarshanOffering::count_all(),
    'bookings'    => Booking::count_all(),
    'messages'    => ContactMessage::count_all(),
    'subscribers' => NewsletterSubscriber::count_all(),
    'users'       => User::count_all(),
];

$pageTitle        = 'Dashboard';
$adminPageHeading = 'Dashboard';
$adminNav         = 'dashboard';
$contentView      = __DIR__ . '/../../views/admin/dashboard.php';

require __DIR__ . '/../../includes/admin_layout.php';
