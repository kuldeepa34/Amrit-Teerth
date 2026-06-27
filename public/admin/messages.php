<?php
/**
 * Admin — Contact messages (read + delete).
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\ContactMessage;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('admin', 'Security check failed. Please try again.', 'error');
        Http::to('messages.php');
    }
    if (($_POST['action'] ?? '') === 'delete') {
        ContactMessage::delete((int) ($_POST['id'] ?? 0));
        Flash::set('admin', 'Message deleted.');
    }
    Http::to('messages.php');
}

$messages         = ContactMessage::all();
$pageTitle        = 'Messages';
$adminPageHeading = 'Contact Messages';
$adminNav         = 'messages';
$contentView      = __DIR__ . '/../../views/admin/messages.php';

require __DIR__ . '/../../includes/admin_layout.php';
