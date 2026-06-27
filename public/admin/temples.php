<?php
/**
 * Admin — Temples. List + create/edit/delete in one controller.
 *   GET  temples.php                  → list
 *   GET  temples.php?action=new       → blank form
 *   GET  temples.php?action=edit&id=N → edit form
 *   POST temples.php  (action=save|delete)
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\Temple;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('admin', 'Security check failed. Please try again.', 'error');
        Http::to('temples.php');
    }

    $action = $_POST['action'] ?? 'save';

    if ($action === 'delete') {
        Temple::delete((int) ($_POST['id'] ?? 0));
        Flash::set('admin', 'Temple deleted.');
        Http::to('temples.php');
    }

    // --- Save (create or update) ---
    $id   = (int) ($_POST['id'] ?? 0);
    $name = trim((string) ($_POST['name'] ?? ''));
    $slug = trim((string) ($_POST['slug'] ?? ''));
    if ($slug === '') {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($name));
        $slug = trim((string) $slug, '-');
    }

    $data = [
        'slug'        => $slug,
        'name'        => $name,
        'deity'       => trim((string) ($_POST['deity'] ?? '')),
        'location'    => trim((string) ($_POST['location'] ?? '')),
        'category'    => (string) ($_POST['category'] ?? 'other'),
        'description' => trim((string) ($_POST['description'] ?? '')),
        'image_url'   => trim((string) ($_POST['image_url'] ?? '')),
        'rating'      => (float) ($_POST['rating'] ?? 5.0),
    ];

    // Validation
    if ($name === '' || $data['location'] === '' || $data['description'] === '' || $data['image_url'] === '') {
        Flash::set('admin', 'Name, location, description and image URL are required.', 'error');
        Http::to($id ? 'temples.php?action=edit&id=' . $id : 'temples.php?action=new');
    }
    if ($slug === '' || Temple::slugExists($slug, $id ?: null)) {
        Flash::set('admin', 'That slug is empty or already in use. Choose a unique slug.', 'error');
        Http::to($id ? 'temples.php?action=edit&id=' . $id : 'temples.php?action=new');
    }

    if ($id) {
        Temple::update($id, $data);
        Flash::set('admin', 'Temple updated.');
    } else {
        Temple::create($data);
        Flash::set('admin', 'Temple added.');
    }
    Http::to('temples.php');
}

// --- GET ---
$action = $_GET['action'] ?? 'list';

if ($action === 'new' || $action === 'edit') {
    $temple = null;
    if ($action === 'edit') {
        $temple = Temple::find((int) ($_GET['id'] ?? 0));
        if ($temple === null) {
            Flash::set('admin', 'Temple not found.', 'error');
            Http::to('temples.php');
        }
    }
    $pageTitle        = $temple ? 'Edit Temple' : 'Add Temple';
    $adminPageHeading = $pageTitle;
    $adminNav         = 'temples';
    $contentView      = __DIR__ . '/../../views/admin/temple-form.php';
} else {
    $temples          = Temple::all();
    $pageTitle        = 'Temples';
    $adminPageHeading = 'Temples';
    $adminNav         = 'temples';
    $contentView      = __DIR__ . '/../../views/admin/temples-list.php';
}

require __DIR__ . '/../../includes/admin_layout.php';
