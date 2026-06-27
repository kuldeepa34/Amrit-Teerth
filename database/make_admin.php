<?php
/**
 * Create (or promote) an admin user, and ensure the `is_admin` column exists.
 *
 * Run:
 *   php database/make_admin.php                         (uses defaults below)
 *   php database/make_admin.php you@example.com secret  (custom email + password)
 *   php database/make_admin.php you@example.com          (promote existing user)
 *
 * Safe to re-run: the column is only added if missing, and an existing user
 * with the same email is promoted (password updated only if one is given).
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;

$email    = $argv[1] ?? 'admin@amritteerth.com';
$password = $argv[2] ?? 'Admin@123';
$name     = 'Administrator';

$pdo = Connection::get();

// 1) Ensure the is_admin column exists (idempotent — works on MySQL & MariaDB).
$hasColumn = (bool) $pdo
    ->query("SHOW COLUMNS FROM `users` LIKE 'is_admin'")
    ->fetchColumn();

if (!$hasColumn) {
    $pdo->exec('ALTER TABLE `users` ADD COLUMN `is_admin` TINYINT(1) NOT NULL DEFAULT 0 AFTER `password_hash`');
    echo "Added `is_admin` column to users table.\n";
}

// 2) Create the admin, or promote them if the email already exists.
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
$stmt->execute(['email' => $email]);
$existingId = $stmt->fetchColumn();

if ($existingId) {
    $pdo->prepare('UPDATE users SET is_admin = 1, password_hash = :hash WHERE id = :id')
        ->execute([
            'hash' => password_hash($password, PASSWORD_DEFAULT),
            'id'   => $existingId,
        ]);
    echo "Promoted existing user to admin: {$email}\n";
} else {
    $pdo->prepare(
        'INSERT INTO users (name, email, password_hash, is_admin)
         VALUES (:name, :email, :hash, 1)'
    )->execute([
        'name'  => $name,
        'email' => $email,
        'hash'  => password_hash($password, PASSWORD_DEFAULT),
    ]);
    echo "Created admin user: {$email}\n";
}

echo "\nAdmin login:\n";
echo "  Email:    {$email}\n";
echo "  Password: {$password}\n";
echo "  Admin URL: /admin/\n";
echo "\nChange this password after first login (or re-run with a new one).\n";
