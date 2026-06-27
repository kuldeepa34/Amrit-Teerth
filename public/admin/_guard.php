<?php
/**
 * Admin gate. Every page under /admin/ requires this file FIRST:
 *
 *   require __DIR__ . '/_guard.php';
 *
 * It bootstraps config, then ensures the visitor is a logged-in admin.
 * Non-logged-in visitors are sent to login (and returned here afterwards);
 * logged-in non-admins get a 403.
 */

declare(strict_types=1);

require __DIR__ . '/../../config/config.php';

use App\Support\Auth;
use App\Support\Http;

if (!Auth::check()) {
    // Remember where they wanted to go, then send them to the login page.
    $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? '/admin/';
    Http::to('../login.php');
}

if (!Auth::isAdmin()) {
    http_response_code(403);
    exit('403 — Admins only. You do not have access to this area.');
}
