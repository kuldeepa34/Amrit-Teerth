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
use App\Support\Throttle;

// Brute-force guard: max 5 failed attempts per 5-minute window.
const LOGIN_MAX_ATTEMPTS = 5;
const LOGIN_DECAY        = 300;

// Already signed in? Nothing to do here.
if (Auth::check()) {
    Http::to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('auth', 'Security check failed. Please try again.', 'error');
        Http::to('login.php');
    }

    if (Throttle::tooManyAttempts('login', LOGIN_MAX_ATTEMPTS, LOGIN_DECAY)) {
        $wait = (int) ceil(Throttle::availableIn('login') / 60);
        Flash::set('auth', "Too many login attempts. Please try again in {$wait} minute(s).", 'error');
        Http::to('login.php');
    }

    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        Flash::set('auth', 'Please enter your email and password.', 'error');
        Http::to('login.php');
    }

    if (Auth::attempt($email, $password)) {
        Throttle::clear('login');
        $dest = $_SESSION['intended_url'] ?? 'index.php';
        unset($_SESSION['intended_url']);
        Http::to($dest);
    }

    Throttle::hit('login', LOGIN_DECAY);
    Flash::set('auth', 'Invalid email or password.', 'error');
    Http::to('login.php');
}

$pageTitle   = 'Login - ' . SITE_NAME;
$activeNav   = '';
$contentView = __DIR__ . '/../views/pages/login.php';

require __DIR__ . '/../includes/layout.php';
