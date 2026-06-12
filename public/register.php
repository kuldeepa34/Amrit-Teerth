<?php
/**
 * Register — shows the form (GET) and processes it (POST).
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;
use App\Models\User;

if (Auth::check()) {
    Http::to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('auth', 'Security check failed. Please try again.', 'error');
        Http::to('register.php');
    }

    $name     = trim((string) ($_POST['name'] ?? ''));
    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirm  = (string) ($_POST['confirm'] ?? '');

    // Validate
    if ($name === '' || $email === '' || $password === '') {
        Flash::set('auth', 'Please fill in all fields.', 'error');
        Http::to('register.php');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Flash::set('auth', 'Please enter a valid email address.', 'error');
        Http::to('register.php');
    }
    if (strlen($password) < 8) {
        Flash::set('auth', 'Password must be at least 8 characters.', 'error');
        Http::to('register.php');
    }
    if ($password !== $confirm) {
        Flash::set('auth', 'Passwords do not match.', 'error');
        Http::to('register.php');
    }
    if (User::emailExists($email)) {
        Flash::set('auth', 'An account with this email already exists. Please log in.', 'error');
        Http::to('login.php');
    }

    User::create($name, $email, $password);
    Auth::login(User::findByEmail($email));
    $dest = $_SESSION['intended_url'] ?? 'index.php';
    unset($_SESSION['intended_url']);
    Http::to($dest);
}

$pageTitle   = 'Create Account - ' . SITE_NAME;
$activeNav   = '';
$contentView = __DIR__ . '/../views/pages/register.php';

require __DIR__ . '/../includes/layout.php';
