<?php
/**
 * Logout — clear the session and return home.
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

use App\Support\Auth;
use App\Support\Flash;
use App\Support\Http;

Auth::logout();
Flash::set('auth', 'You have been signed out. 🙏', 'success');
Http::to('index.php');
