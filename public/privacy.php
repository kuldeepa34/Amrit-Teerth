<?php
/**
 * Privacy Policy — static informational page (rendered via the shared legal view).
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle    = 'Privacy Policy - ' . SITE_NAME;
$activeNav    = '';
$legalTitle   = 'Privacy Policy';
$legalLead    = 'Your trust is sacred to us. This policy explains what we collect, why, and how we protect it.';
$legalUpdated = 'June 16, 2026';
$legalSections = [
    [
        'heading' => 'Information we collect',
        'body'    => [
            'When you create an account, book a darshan, contact us, or subscribe to our newsletter, we collect the details you provide — such as your name, email address, and booking preferences.',
            'We do not collect payment card details on this site; any payment is handled by the temple or partner at the time of your visit.',
        ],
    ],
    [
        'heading' => 'How we use your information',
        'body'    => [
            'To confirm and manage your darshan bookings, to respond to your enquiries, and — only if you opt in — to send occasional updates about new offerings and temple events.',
            'We never sell your personal information to third parties.',
        ],
    ],
    [
        'heading' => 'How we protect it',
        'body'    => [
            'Passwords are stored only as one-way secure hashes — never in plain text. Forms are protected against cross-site request forgery, and our sessions use HTTP-only, same-site cookies.',
        ],
    ],
    [
        'heading' => 'Your choices',
        'body'    => [
            'You can unsubscribe from our newsletter at any time using the link in any email. To request access to, correction of, or deletion of your data, write to us via the Contact page.',
        ],
    ],
    [
        'heading' => 'Contact',
        'body'    => [
            'Questions about this policy? Reach us through the Contact page and our team will respond within 24 hours.',
        ],
    ],
];
$contentView = __DIR__ . '/../views/pages/legal.php';

require __DIR__ . '/../includes/layout.php';
