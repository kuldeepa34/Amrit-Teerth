<?php
/**
 * Base layout.
 * Wires the shared chrome (head + header + footer) around a page's view.
 *
 * Entry files should set, before requiring this file:
 *   $pageTitle    – document title          (optional)
 *   $activeNav    – active nav key           (optional)
 *   $contentView  – absolute path to the page's view file (required)
 */
declare(strict_types=1);

if (!isset($contentView) || !is_file($contentView)) {
    http_response_code(500);
    exit('Layout error: $contentView is not set to a valid view file.');
}

require __DIR__ . '/head.php';
require __DIR__ . '/header.php';
require $contentView;          // page-specific <main> content
require __DIR__ . '/footer.php';
