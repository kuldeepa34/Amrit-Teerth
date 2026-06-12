<?php
/**
 * Contact form handler.
 * POST only → validate → store → redirect to contact.php with a flash message.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Support\Flash;
use App\Support\Csrf;
use App\Support\Http;
use App\Support\Mailer;
use App\Models\ContactMessage;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Http::to('contact.php');
}

if (!Csrf::check($_POST['_csrf'] ?? null)) {
    Flash::set('contact', 'Security check failed. Please try again.', 'error');
    Http::to('contact.php');
}

$fullName = trim((string) ($_POST['fullName'] ?? ''));
$email    = trim((string) ($_POST['emailAddress'] ?? ''));
$service  = trim((string) ($_POST['serviceInterest'] ?? ''));
$message  = trim((string) ($_POST['message'] ?? ''));

// Validate
$errors = [];
if ($fullName === '') {
    $errors[] = 'your name';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'a valid email';
}
if ($message === '') {
    $errors[] = 'a message';
}

if ($errors !== []) {
    Flash::set('contact', 'Please provide ' . implode(', ', $errors) . '.', 'error');
    Http::to('contact.php');
}

ContactMessage::create($fullName, $email, $service, $message);

// Best-effort notification email (no-op if SMTP isn't configured).
Mailer::send(
    Mailer::adminAddress(),
    'New contact message from ' . $fullName,
    "Name: {$fullName}\nEmail: {$email}\nService: " . ($service !== '' ? $service : '—') . "\n\n{$message}",
    $email
);

Flash::set('contact', 'Thank you, ' . $fullName . '. Our guides will respond within 24 hours. 🙏', 'success');
Http::to('contact.php');
