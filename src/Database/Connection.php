<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Single, shared PDO database connection.
 *
 * Usage:
 *   $pdo = \App\Database\Connection::get();
 *   $stmt = $pdo->prepare('SELECT * FROM temples WHERE id = ?');
 *
 * The connection is created once (lazily) and reused for the whole request.
 */
final class Connection
{
    private static ?PDO $pdo = null;

    /** Returns the shared PDO instance, creating it on first use. */
    public static function get(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $config = require dirname(__DIR__, 2) . '/config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['name'],
            $config['charset']
        );

        try {
            self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // throw on errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // assoc arrays
                PDO::ATTR_EMULATE_PREPARES   => false,                   // real prepared statements
            ]);
        } catch (PDOException $e) {
            // Never leak credentials/DSN to the browser.
            throw new RuntimeException('Database connection failed. Check config/database.php and that MySQL is running.', 0, $e);
        }

        return self::$pdo;
    }

    /** Prevent instantiation — this is a static helper. */
    private function __construct()
    {
    }
}
