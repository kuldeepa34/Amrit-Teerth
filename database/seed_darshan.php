<?php
/**
 * Seed the darshan_offerings table. Re-runnable (ON DUPLICATE KEY by slug).
 * Run:  php database/seed_darshan.php
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;

$img = [
    'temple_ext' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBR_tJfXKFqoK6-hlQy-8IUAQMMqpO-VbnGdobavoBXk1xq-o7SctDnBaPc_BhoZ2aPnyZCGKrhwC-3AzSDmCPqiZQTWun5QzQSlrNHTivpM_pppgF8f9WTZ5o7lTI343h5tjy3H8TB_F_zpBr9tsqm_qisDws2Q2XmxkKilxhY50V-uAAc2ph5ql5jfreHrzHynxzaGMWC1jCGLyBw6q9cWkHKuKFP9fIZ_OvqqE07u-1bmw58PdpsAmwKy937z9Kt4YdFJCVqA_Y',
    'temple_int' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_sH7a_SIMDgQuXa3AeLh2pRDQfc2HI92CuxBregHzgLK7mgyyHJP2qB_Q0H1Z8DbInCtMT3BUtac7LXmD-_DvPatBJtWCjmaQhhfoIXHEOAam2GzK1T1TJqJgFZdtYVPcNYzMyd6ENTpJxgofvoozno4CkAwovPuF7sDrg8nE51Qly1AkZrtKmz895cRMxlkUFWm095-W9nXZ1f_ydJzlO0gJ95Gsie7a7JgYHqR3njjFdlDTB6VpLrN6B3v5sGttf5iubRewv4U',
    'lamp'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCE6tSTExb_k2RHjAskNFt7m1IKvUeWaWCXv3f0MRHfPxDmDIeLWpHfeQ6ycyt0LwiF-VuYFO-QGwVZpD6ZM1OokyYyUNAQJmbYMdxJLwf8k_6f9Ah9RFgdtWhRz5ql-VoqBkS439KRVzOVwx_1-Fw6U2d4zQ6WC-DjUl12ESbET-4Wd308Y-X-05RMuNsEDDtYob2hO1H7VEJsc1yKONVrGN--c1XsV6uniFuTalPgJhHfGsMTwY3ZaU5zjJPxzIWEoxaLUyGQ_x8',
    'kashi'      => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3Syil9pr5VNMHBcI8Zx4kYhPRro2AN8b--5f2D-tWJ3xtdUEzIUuK7I0E6x4f-X2GqhnURh36AJZipdqWxV-vPqG0bb-q-F3r_5L_l7UgcWbY9UDMIy4SPt8AmLll8gReU2ku6je0bb-GtVfaZ8-clO2u5ldg2qw1bhmAmNgew6PXYFZAX7zktbnKnJX4iezunTHjC9wbANlMF33_Dkd3O-b0nVXVFdafc6ru4rWmJARSPu-MZSPNMpcff9oqUoYNzkIQz5bktdM',
    'mountains'  => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBHvl-_hQYgL-qbIC8yLjmXkWD4Nf52PkxOh5Jr7Wt4qpqmkzMDMyHZEf_v2wfAyneBcVPodG0wEeC5-JFM0AlR22lA7BVWIjmqXgq1-6lySyXAs1K4aW8bsp1PG-SJgVhYFQz1wB0oFDJyYbQrBtZ9Kmoh_8fzT9vbCFbpHiIuKYLhpN6ZKYZaQycoUjv2UakPHel45ozHxk7YT04LUtW35bgNZEOFBSIWbtbr3dZrPMGpS8bPbAgT1KY0nV2cFeq8MN-2vw2H8bM',
    'madurai'    => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCTMEw2TH6MYIklcO4LOBek8ntNy6HYn-lWVKxTOszC2b1p7ejvRWTomMQNNiwakABRBnjoEuw8n4Sz-d5v4IYwRbCjbh8l73U9rvYOKBM6ExbHHKHNV4W7FsNDT-vZI7wjmToFgbhV6pyOAFYawvLBX_4tTPhi1U_7bD_RqObF2N9-TJ2v97Ho2Uud1G0JdKF1tvVdL3oBYw82Fhv3eq_pYqatYJTnMBvRixgcqPuPtPn0h7uOfUgbjdO7Jg8LxQCxU5r31u8A1LE',
    'golden'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEbHWDmcs_xrf_Spdoi5pnCT3NZAQW5HTGRDcynmC48nTcCZ2NL6-odv4N9fUE8TlBEdKp9CvyIW4VpO0ZezcNjhYSXGTeJaZKf5_aYaB3WcYkY7qq2xCfflIevrcjcnjsS1IKj2n_Az7mLdRhe5aGBrAB8F2HL_m4AKUzizwDk6x8NtNuuYfoGGoy8WNIwFplNWueWaoKduyZFqAeSbYR7keF3KYs0nCaskDwG4fZqwrgtcGK6VvvyeNyCOQB3-1Vyidz-yaIEzw',
];

$offerings = [
    ['slug' => 'kashi-daily', 'temple_name' => 'Kashi Vishwanath', 'location' => 'Varanasi, Uttar Pradesh',
     'category' => 'daily-darshan', 'rating' => 4.9, 'image_url' => $img['temple_ext'],
     'schedule' => [['name' => 'Mangala Arati', 'time' => '03:00 AM'], ['name' => 'Bhog Arati', 'time' => '11:15 AM']]],

    ['slug' => 'tirupati-vip', 'temple_name' => 'Tirupati Balaji', 'location' => 'Tirumala, Andhra Pradesh',
     'category' => 'vip-darshan', 'rating' => 4.8, 'image_url' => $img['temple_int'],
     'schedule' => [['name' => 'Suprabhatam', 'time' => '02:30 AM'], ['name' => 'Thomala Seva', 'time' => '03:30 AM']]],

    ['slug' => 'somnath-arati', 'temple_name' => 'Somnath Temple', 'location' => 'Prabhas Patan, Gujarat',
     'category' => 'special-arati', 'rating' => 5.0, 'image_url' => $img['lamp'],
     'schedule' => [['name' => 'Morning Arati', 'time' => '07:00 AM'], ['name' => 'Evening Arati', 'time' => '07:00 PM']]],

    ['slug' => 'mahakaleshwar-bhasma', 'temple_name' => 'Mahakaleshwar', 'location' => 'Ujjain, Madhya Pradesh',
     'category' => 'special-arati', 'rating' => 4.9, 'image_url' => $img['kashi'],
     'schedule' => [['name' => 'Bhasma Arati', 'time' => '04:00 AM'], ['name' => 'Sandhya Arati', 'time' => '07:00 PM']]],

    ['slug' => 'vaishno-devi-daily', 'temple_name' => 'Vaishno Devi', 'location' => 'Katra, Jammu & Kashmir',
     'category' => 'daily-darshan', 'rating' => 4.9, 'image_url' => $img['mountains'],
     'schedule' => [['name' => 'Morning Darshan', 'time' => '05:00 AM'], ['name' => 'Evening Darshan', 'time' => '06:00 PM']]],

    ['slug' => 'meenakshi-festival', 'temple_name' => 'Meenakshi Amman', 'location' => 'Madurai, Tamil Nadu',
     'category' => 'festivals', 'rating' => 4.8, 'image_url' => $img['madurai'],
     'schedule' => [['name' => 'Chithirai Festival', 'time' => '06:00 AM'], ['name' => 'Night Procession', 'time' => '09:00 PM']]],

    ['slug' => 'golden-temple-vip', 'temple_name' => 'Golden Temple', 'location' => 'Amritsar, Punjab',
     'category' => 'vip-darshan', 'rating' => 5.0, 'image_url' => $img['golden'],
     'schedule' => [['name' => 'Prakash Ceremony', 'time' => '04:00 AM'], ['name' => 'Palki Sahib', 'time' => '09:30 PM']]],
];

$pdo  = Connection::get();
$stmt = $pdo->prepare(
    'INSERT INTO darshan_offerings (slug, temple_name, location, category, image_url, rating, schedule)
     VALUES (:slug, :temple_name, :location, :category, :image_url, :rating, :schedule)
     ON DUPLICATE KEY UPDATE
        temple_name = VALUES(temple_name), location = VALUES(location), category = VALUES(category),
        image_url = VALUES(image_url), rating = VALUES(rating), schedule = VALUES(schedule)'
);

foreach ($offerings as $o) {
    $o['schedule'] = json_encode($o['schedule'], JSON_UNESCAPED_UNICODE);
    $stmt->execute($o);
}

echo 'Seeded ' . count($offerings) . " darshan offerings.\n";
