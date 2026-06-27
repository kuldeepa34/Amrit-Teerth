<?php
/**
 * Admin — Puja / Darshan offerings. List + create/edit/delete.
 */
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use App\Models\DarshanOffering;
use App\Support\Csrf;
use App\Support\Flash;
use App\Support\Http;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['_csrf'] ?? null)) {
        Flash::set('admin', 'Security check failed. Please try again.', 'error');
        Http::to('darshan.php');
    }

    $action = $_POST['action'] ?? 'save';

    if ($action === 'delete') {
        DarshanOffering::delete((int) ($_POST['id'] ?? 0));
        Flash::set('admin', 'Offering deleted.');
        Http::to('darshan.php');
    }

    $id          = (int) ($_POST['id'] ?? 0);
    $templeName  = trim((string) ($_POST['temple_name'] ?? ''));
    $slug        = trim((string) ($_POST['slug'] ?? ''));
    if ($slug === '') {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($templeName . '-' . ($_POST['category'] ?? '')));
        $slug = trim((string) $slug, '-');
    }

    // Schedule comes as parallel arrays: schedule_name[], schedule_time[]
    $schedule = [];
    $names    = (array) ($_POST['schedule_name'] ?? []);
    $times    = (array) ($_POST['schedule_time'] ?? []);
    foreach ($names as $i => $n) {
        $schedule[] = ['name' => (string) $n, 'time' => (string) ($times[$i] ?? '')];
    }

    $data = [
        'slug'        => $slug,
        'temple_name' => $templeName,
        'location'    => trim((string) ($_POST['location'] ?? '')),
        'category'    => (string) ($_POST['category'] ?? 'daily-darshan'),
        'image_url'   => trim((string) ($_POST['image_url'] ?? '')),
        'rating'      => (float) ($_POST['rating'] ?? 5.0),
        'schedule'    => $schedule,
    ];

    if ($templeName === '' || $data['location'] === '' || $data['image_url'] === '') {
        Flash::set('admin', 'Temple name, location and image URL are required.', 'error');
        Http::to($id ? 'darshan.php?action=edit&id=' . $id : 'darshan.php?action=new');
    }
    if ($slug === '' || DarshanOffering::slugExists($slug, $id ?: null)) {
        Flash::set('admin', 'That slug is empty or already in use. Choose a unique slug.', 'error');
        Http::to($id ? 'darshan.php?action=edit&id=' . $id : 'darshan.php?action=new');
    }

    if ($id) {
        DarshanOffering::update($id, $data);
        Flash::set('admin', 'Offering updated.');
    } else {
        DarshanOffering::create($data);
        Flash::set('admin', 'Offering added.');
    }
    Http::to('darshan.php');
}

$action = $_GET['action'] ?? 'list';

if ($action === 'new' || $action === 'edit') {
    $offering = null;
    if ($action === 'edit') {
        $offering = DarshanOffering::find((int) ($_GET['id'] ?? 0));
        if ($offering === null) {
            Flash::set('admin', 'Offering not found.', 'error');
            Http::to('darshan.php');
        }
    }
    $pageTitle        = $offering ? 'Edit Offering' : 'Add Offering';
    $adminPageHeading = $pageTitle;
    $adminNav         = 'darshan';
    $contentView      = __DIR__ . '/../../views/admin/darshan-form.php';
} else {
    $offerings        = DarshanOffering::all();
    $pageTitle        = 'Puja / Darshan';
    $adminPageHeading = 'Puja / Darshan';
    $adminNav         = 'darshan';
    $contentView      = __DIR__ . '/../../views/admin/darshan-list.php';
}

require __DIR__ . '/../../includes/admin_layout.php';
