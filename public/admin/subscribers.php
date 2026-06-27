<?php
/**
 * Admin — Newsletter subscribers (list, delete, CSV export).
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\NewsletterSubscriber;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('admin', 'Security check failed. Please try again.', 'error');
        Http::to('subscribers.php');
    }
    if (($_POST['action'] ?? '') === 'delete') {
        NewsletterSubscriber::delete((int) ($_POST['id'] ?? 0));
        Flash::set('admin', 'Subscriber removed.');
    }
    Http::to('subscribers.php');
}

$subscribers = NewsletterSubscriber::all();

// CSV export
if (($_GET['export'] ?? '') === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="subscribers.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Email', 'Subscribed At']);
    foreach ($subscribers as $s) {
        fputcsv($out, [$s['email'], $s['created_at']]);
    }
    fclose($out);
    exit;
}

$pageTitle        = 'Subscribers';
$adminPageHeading = 'Newsletter Subscribers';
$adminNav         = 'subscribers';
$contentView      = __DIR__ . '/../../views/admin/subscribers.php';

require __DIR__ . '/../../includes/admin_layout.php';
