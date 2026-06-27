<?php
/**
 * Terms of Service — static informational page (rendered via the shared legal view).
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle    = 'Terms of Service - ' . SITE_NAME;
$activeNav    = '';
$legalTitle   = 'Terms of Service';
$legalLead    = 'Please read these terms carefully. By using Amrit Teerth you agree to them.';
$legalUpdated = 'June 16, 2026';
$legalSections = [
    [
        'heading' => 'Using our platform',
        'body'    => [
            'Amrit Teerth lets you discover temples, read spiritual content, and reserve darshan slots. You agree to provide accurate information and to use the platform respectfully and lawfully.',
        ],
    ],
    [
        'heading' => 'Bookings',
        'body'    => [
            'A booking confirmation reserves your chosen slot subject to the temple\'s rules and capacity. Timings may change for festivals, rituals, or unforeseen circumstances; we will make reasonable efforts to inform you.',
            'Please arrive on time for your slot. Late arrivals may be accommodated subject to availability.',
        ],
    ],
    [
        'heading' => 'Accounts',
        'body'    => [
            'You are responsible for keeping your account credentials confidential and for activity under your account. Notify us promptly of any unauthorised use.',
        ],
    ],
    [
        'heading' => 'Content',
        'body'    => [
            'Articles, images, and offerings on this site are for personal, non-commercial use. You may not copy or redistribute them without permission.',
        ],
    ],
    [
        'heading' => 'Changes to these terms',
        'body'    => [
            'We may update these terms from time to time. Continued use of the platform after changes means you accept the revised terms.',
        ],
    ],
];
$contentView = __DIR__ . '/../views/pages/legal.php';

require __DIR__ . '/../includes/layout.php';
