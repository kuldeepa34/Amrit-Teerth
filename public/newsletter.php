<?php
/**
 * Newsletter subscription handler (footer + blog sidebar forms).
 * POST only → validate → store → redirect back with a flash message.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Support\Flash;
use App\Support\Csrf;
use App\Support\Http;
use App\Support\Mailer;
use App\Models\NewsletterSubscriber;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Http::to('index.php');
}

if (!Csrf::check($_POST['_csrf'] ?? null)) {
    Flash::set('newsletter', 'Security check failed. Please try again.', 'error');
    Http::back();
}

$email = trim((string) ($_POST['email'] ?? ''));

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Flash::set('newsletter', 'Please enter a valid email address.', 'error');
    Http::back();
}

NewsletterSubscriber::subscribe($email);

// Best-effort welcome email (no-op if SMTP isn't configured).
Mailer::send(
    $email,
    'Welcome to Amrit Teerth Spiritual Insights 🙏',
    "Thank you for subscribing.\n\nYou'll now receive our weekly articles, exclusive service offers, and guided meditations.\n\nWith gratitude,\nThe Amrit Teerth Team"
);

Flash::set('newsletter', 'Thank you for subscribing to Spiritual Insights. 🙏', 'success');
Http::back();
