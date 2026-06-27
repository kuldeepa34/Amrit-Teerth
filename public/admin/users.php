<?php
/**
 * Admin — Users (view + grant/revoke admin).
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\User;
use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('admin', 'Security check failed. Please try again.', 'error');
        Http::to('users.php');
    }

    $id = (int) ($_POST['id'] ?? 0);

    if (($_POST['action'] ?? '') === 'toggle-admin') {
        if ($id === Auth::id()) {
            Flash::set('admin', "You can't change your own admin status.", 'error');
        } else {
            $makeAdmin = ($_POST['make'] ?? '') === '1';
            User::setAdmin($id, $makeAdmin);
            Flash::set('admin', $makeAdmin ? 'User promoted to admin.' : 'Admin rights revoked.');
        }
    }
    Http::to('users.php');
}

$users            = User::all();
$pageTitle        = 'Users';
$adminPageHeading = 'Users';
$adminNav         = 'users';
$contentView      = __DIR__ . '/../../views/admin/users.php';

require __DIR__ . '/../../includes/admin_layout.php';
