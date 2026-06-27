<?php
/**
 * FAQ — static Q&A page (rendered via the shared legal view).
 */
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

$pageTitle  = 'FAQ - ' . SITE_NAME;
$activeNav  = '';
$legalTitle = 'Frequently Asked Questions';
$legalLead  = 'Answers to the things devotees ask us most. Still stuck? The Contact page is one tap away.';
$legalSections = [
    [
        'heading' => 'Do I need an account to book a darshan?',
        'body'    => ['Yes. A free account lets us confirm your slot and keep your booking history in one place. You can register in under a minute.'],
    ],
    [
        'heading' => 'Is there any charge to use Amrit Teerth?',
        'body'    => ['Browsing temples, reading blogs, and reserving darshan slots on the platform is free. Any offering or contribution at the temple itself is handled directly by the temple.'],
    ],
    [
        'heading' => 'Can I cancel or change a booking?',
        'body'    => ['Booking timings depend on each temple. To change or cancel, reach out via the Contact page with your booking details and our guides will assist you.'],
    ],
    [
        'heading' => 'How many devotees can I book for?',
        'body'    => ['Each booking covers between 1 and 10 devotees. For larger groups or special ceremonies, contact us and we will arrange it for you.'],
    ],
    [
        'heading' => 'How will I receive confirmation?',
        'body'    => ['You will see an instant on-screen confirmation, and your booking appears under "Your Recent Bookings". If email is configured, a confirmation is also sent to your inbox.'],
    ],
    [
        'heading' => 'Who do I contact for help?',
        'body'    => ['Use the Contact page any time — our team responds within 24 hours.'],
    ],
];
$contentView = __DIR__ . '/../views/pages/legal.php';

require __DIR__ . '/../includes/layout.php';
