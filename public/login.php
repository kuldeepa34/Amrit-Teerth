<?php
/**
 * Login — shows the form (GET) and processes it (POST).
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

// Already signed in? Nothing to do here.
if (Auth::check()) {
    Http::to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('auth', 'Security check failed. Please try again.', 'error');
        Http::to('login.php');
    }

    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        Flash::set('auth', 'Please enter your email and password.', 'error');
        Http::to('login.php');
    }

    if (Auth::attempt($email, $password)) {
        $dest = $_SESSION['intended_url'] ?? 'index.php';
        unset($_SESSION['intended_url']);
        Http::to($dest);
    }

    Flash::set('auth', 'Invalid email or password.', 'error');
    Http::to('login.php');
}

$pageTitle   = 'Login - ' . SITE_NAME;
$activeNav   = '';
$contentView = __DIR__ . '/../views/pages/login.php';

require __DIR__ . '/../includes/layout.php';
