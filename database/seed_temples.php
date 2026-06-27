<?php
/**
 * Seed the temples table with starter data.
 * Re-runnable: uses INSERT ... ON DUPLICATE KEY so existing slugs are updated,
 * not duplicated.
 *
 * Run:  php database/seed_temples.php
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;

$temples = [
    [
        'slug' => 'kashi-vishwanath', 'name' => 'Kashi Vishwanath', 'deity' => 'Lord Shiva',
        'location' => 'Varanasi, Uttar Pradesh', 'category' => 'jyotirlinga', 'rating' => 4.9,
        'description' => 'One of the most famous Hindu temples dedicated to Lord Shiva, located in Varanasi — one of the holiest existing places for Hindus.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3Syil9pr5VNMHBcI8Zx4kYhPRro2AN8b--5f2D-tWJ3xtdUEzIUuK7I0E6x4f-X2GqhnURh36AJZipdqWxV-vPqG0bb-q-F3r_5L_l7UgcWbY9UDMIy4SPt8AmLll8gReU2ku6je0bb-GtVfaZ8-clO2u5ldg2qw1bhmAmNgew6PXYFZAX7zktbnKnJX4iezunTHjC9wbANlMF33_Dkd3O-b0nVXVFdafc6ru4rWmJARSPu-MZSPNMpcff9oqUoYNzkIQz5bktdM',
    ],
    [
        'slug' => 'sri-venkateswara', 'name' => 'Sri Venkateswara Swamy', 'deity' => 'Lord Venkateswara',
        'location' => 'Tirumala, Andhra Pradesh', 'category' => 'south-indian', 'rating' => 4.8,
        'description' => 'A landmark Vaishnavite temple in the hill town of Tirumala — one of the richest and most visited religious centers in the world.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYRCGZDnhjZN1TAmQMqEk05aeszx3lzwigCXJILLUv0UGwOF9u6lfNo6k8FXQz7lYF9UsudcD6VJjfeHpgns-HKUBUwKYtfOMw2365BCWMwd3vnANBrE7f7R_vsXN_22nSAoHiMK6k6bkt0RA7bBN_ouK5Z9vSaUr2CUGLxJlP38gv6o6fxZodL2Tk-NkQBIagtcqKcSvAuCFarEzUWCQpyKQPuCd8w0TDW7m1MaRgCAts0QyENgfEKa_NEq2K4l_u4Cv5mzAyfD8',
    ],
    [
        'slug' => 'harmandir-sahib', 'name' => 'Sri Harmandir Sahib', 'deity' => 'Guru Granth Sahib',
        'location' => 'Amritsar, Punjab', 'category' => 'other', 'rating' => 5.0,
        'description' => 'The preeminent spiritual site of Sikhism, famous for its full golden dome, built on a lower level than the surrounding land to signify egalitarianism.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEbHWDmcs_xrf_Spdoi5pnCT3NZAQW5HTGRDcynmC48nTcCZ2NL6-odv4N9fUE8TlBEdKp9CvyIW4VpO0ZezcNjhYSXGTeJaZKf5_aYaB3WcYkY7qq2xCfflIevrcjcnjsS1IKj2n_Az7mLdRhe5aGBrAB8F2HL_m4AKUzizwDk6x8NtNuuYfoGGoy8WNIwFplNWueWaoKduyZFqAeSbYR7keF3KYs0nCaskDwG4fZqwrgtcGK6VvvyeNyCOQB3-1Vyidz-yaIEzw',
    ],
    [
        'slug' => 'somnath', 'name' => 'Somnath Temple', 'deity' => 'Lord Shiva',
        'location' => 'Prabhas Patan, Gujarat', 'category' => 'jyotirlinga', 'rating' => 4.9,
        'description' => 'The first among the twelve Jyotirlinga shrines of Shiva, renowned for its seaside grandeur and storied history of resilience.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCE6tSTExb_k2RHjAskNFt7m1IKvUeWaWCXv3f0MRHfPxDmDIeLWpHfeQ6ycyt0LwiF-VuYFO-QGwVZpD6ZM1OokyYyUNAQJmbYMdxJLwf8k_6f9Ah9RFgdtWhRz5ql-VoqBkS439KRVzOVwx_1-Fw6U2d4zQ6WC-DjUl12ESbET-4Wd308Y-X-05RMuNsEDDtYob2hO1H7VEJsc1yKONVrGN--c1XsV6uniFuTalPgJhHfGsMTwY3ZaU5zjJPxzIWEoxaLUyGQ_x8',
    ],
    [
        'slug' => 'meenakshi-amman', 'name' => 'Meenakshi Amman', 'deity' => 'Goddess Meenakshi',
        'location' => 'Madurai, Tamil Nadu', 'category' => 'south-indian', 'rating' => 4.8,
        'description' => 'A historic temple celebrated for its towering, intricately sculpted gopurams and vibrant Dravidian architecture.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCTMEw2TH6MYIklcO4LOBek8ntNy6HYn-lWVKxTOszC2b1p7ejvRWTomMQNNiwakABRBnjoEuw8n4Sz-d5v4IYwRbCjbh8l73U9rvYOKBM6ExbHHKHNV4W7FsNDT-vZI7wjmToFgbhV6pyOAFYawvLBX_4tTPhi1U_7bD_RqObF2N9-TJ2v97Ho2Uud1G0JdKF1tvVdL3oBYw82Fhv3eq_pYqatYJTnMBvRixgcqPuPtPn0h7uOfUgbjdO7Jg8LxQCxU5r31u8A1LE',
    ],
    [
        'slug' => 'kamakhya', 'name' => 'Kamakhya Temple', 'deity' => 'Goddess Kamakhya',
        'location' => 'Guwahati, Assam', 'category' => 'shakti-peetha', 'rating' => 4.7,
        'description' => 'One of the oldest and most revered Shakti Peethas, set atop Nilachal Hill and central to Tantric worship traditions.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuChNizIVoBhPIb3VX3NFq8Yc2RI9DAA54mSq-A09pUg2YcdE929T_xBOxIwOCpQIW1DBv4_fAnCb2m4A2q3QUxD21BfD6MobKEvnrcvalBJKHPr4nfeYHO_Azsi-Iks0J6Y_LTupmfh58J6oCHixI1kZFC6lsNUdGFRyp7BOq-hj0SKvMWgaJII71jQvLER5qe6tuDTnl0Y87BYkyEcxr1GRSJ0WPBXhIVYYn9ezUdfwXFmXwLm2Lm071PTkI4MXPRNmbfVadUKCBs',
    ],
    // --- Ujjain — the sacred city of Mahakal. All temples below are in Ujjain, MP. ---
    [
        'slug' => 'mahakaleshwar', 'name' => 'Mahakaleshwar', 'deity' => 'Lord Shiva',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'jyotirlinga', 'rating' => 4.9,
        'description' => 'A revered Jyotirlinga famed for its Bhasma Aarti, where the deity is worshipped as the lord of time itself.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBR_tJfXKFqoK6-hlQy-8IUAQMMqpO-VbnGdobavoBXk1xq-o7SctDnBaPc_BhoZ2aPnyZCGKrhwC-3AzSDmCPqiZQTWun5QzQSlrNHTivpM_pppgF8f9WTZ5o7lTI343h5tjy3H8TB_F_zpBr9tsqm_qisDws2Q2XmxkKilxhY50V-uAAc2ph5ql5jfreHrzHynxzaGMWC1jCGLyBw6q9cWkHKuKFP9fIZ_OvqqE07u-1bmw58PdpsAmwKy937z9Kt4YdFJCVqA_Y',
    ],
    [
        'slug' => 'kal-bhairav-ujjain', 'name' => 'Kal Bhairav Temple', 'deity' => 'Lord Kal Bhairav',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.7,
        'description' => 'An ancient temple of the guardian deity of Ujjain, renowned for the unique tradition of offering liquor to the deity as prasad.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBR_tJfXKFqoK6-hlQy-8IUAQMMqpO-VbnGdobavoBXk1xq-o7SctDnBaPc_BhoZ2aPnyZCGKrhwC-3AzSDmCPqiZQTWun5QzQSlrNHTivpM_pppgF8f9WTZ5o7lTI343h5tjy3H8TB_F_zpBr9tsqm_qisDws2Q2XmxkKilxhY50V-uAAc2ph5ql5jfreHrzHynxzaGMWC1jCGLyBw6q9cWkHKuKFP9fIZ_OvqqE07u-1bmw58PdpsAmwKy937z9Kt4YdFJCVqA_Y',
    ],
    [
        'slug' => 'harsiddhi-ujjain', 'name' => 'Harsiddhi Temple', 'deity' => 'Goddess Harsiddhi',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'shakti-peetha', 'rating' => 4.7,
        'description' => 'A celebrated Shakti Peetha near Rudra Sagar lake, distinguished by its two towering deepstambhas (lamp pillars) lit during festivals.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuChNizIVoBhPIb3VX3NFq8Yc2RI9DAA54mSq-A09pUg2YcdE929T_xBOxIwOCpQIW1DBv4_fAnCb2m4A2q3QUxD21BfD6MobKEvnrcvalBJKHPr4nfeYHO_Azsi-Iks0J6Y_LTupmfh58J6oCHixI1kZFC6lsNUdGFRyp7BOq-hj0SKvMWgaJII71jQvLER5qe6tuDTnl0Y87BYkyEcxr1GRSJ0WPBXhIVYYn9ezUdfwXFmXwLm2Lm071PTkI4MXPRNmbfVadUKCBs',
    ],
    [
        'slug' => 'mangalnath-ujjain', 'name' => 'Mangalnath Temple', 'deity' => 'Lord Mangal (Mars)',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.6,
        'description' => 'Regarded as the birthplace of the planet Mars (Mangal), this temple on the banks of the Shipra draws devotees seeking relief from Mangal dosha.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBR_tJfXKFqoK6-hlQy-8IUAQMMqpO-VbnGdobavoBXk1xq-o7SctDnBaPc_BhoZ2aPnyZCGKrhwC-3AzSDmCPqiZQTWun5QzQSlrNHTivpM_pppgF8f9WTZ5o7lTI343h5tjy3H8TB_F_zpBr9tsqm_qisDws2Q2XmxkKilxhY50V-uAAc2ph5ql5jfreHrzHynxzaGMWC1jCGLyBw6q9cWkHKuKFP9fIZ_OvqqE07u-1bmw58PdpsAmwKy937z9Kt4YdFJCVqA_Y',
    ],
    [
        'slug' => 'chintaman-ganesh-ujjain', 'name' => 'Chintaman Ganesh', 'deity' => 'Lord Ganesha',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.6,
        'description' => 'One of the oldest Ganesha temples in Ujjain, where the lord is revered as the remover of worries (chinta).',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3Syil9pr5VNMHBcI8Zx4kYhPRro2AN8b--5f2D-tWJ3xtdUEzIUuK7I0E6x4f-X2GqhnURh36AJZipdqWxV-vPqG0bb-q-F3r_5L_l7UgcWbY9UDMIy4SPt8AmLll8gReU2ku6je0bb-GtVfaZ8-clO2u5ldg2qw1bhmAmNgew6PXYFZAX7zktbnKnJX4iezunTHjC9wbANlMF33_Dkd3O-b0nVXVFdafc6ru4rWmJARSPu-MZSPNMpcff9oqUoYNzkIQz5bktdM',
    ],
    [
        'slug' => 'gadkalika-ujjain', 'name' => 'Gadkalika Temple', 'deity' => 'Goddess Kalika',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.5,
        'description' => 'An ancient shrine of Goddess Kalika, traditionally associated with the great poet Kalidasa, who is said to have been blessed with wisdom here.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuChNizIVoBhPIb3VX3NFq8Yc2RI9DAA54mSq-A09pUg2YcdE929T_xBOxIwOCpQIW1DBv4_fAnCb2m4A2q3QUxD21BfD6MobKEvnrcvalBJKHPr4nfeYHO_Azsi-Iks0J6Y_LTupmfh58J6oCHixI1kZFC6lsNUdGFRyp7BOq-hj0SKvMWgaJII71jQvLER5qe6tuDTnl0Y87BYkyEcxr1GRSJ0WPBXhIVYYn9ezUdfwXFmXwLm2Lm071PTkI4MXPRNmbfVadUKCBs',
    ],
    [
        'slug' => 'sandipani-ashram-ujjain', 'name' => 'Sandipani Ashram', 'deity' => 'Lord Krishna',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.6,
        'description' => 'The legendary ashram where Lord Krishna, Balarama and Sudama received their education under Guru Sandipani.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYRCGZDnhjZN1TAmQMqEk05aeszx3lzwigCXJILLUv0UGwOF9u6lfNo6k8FXQz7lYF9UsudcD6VJjfeHpgns-HKUBUwKYtfOMw2365BCWMwd3vnANBrE7f7R_vsXN_22nSAoHiMK6k6bkt0RA7bBN_ouK5Z9vSaUr2CUGLxJlP38gv6o6fxZodL2Tk-NkQBIagtcqKcSvAuCFarEzUWCQpyKQPuCd8w0TDW7m1MaRgCAts0QyENgfEKa_NEq2K4l_u4Cv5mzAyfD8',
    ],
    [
        'slug' => 'bade-ganeshji-ujjain', 'name' => 'Bade Ganeshji Ka Mandir', 'deity' => 'Lord Ganesha',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.5,
        'description' => 'Home to one of the largest artistic idols of Lord Ganesha, located close to the Mahakaleshwar temple.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3Syil9pr5VNMHBcI8Zx4kYhPRro2AN8b--5f2D-tWJ3xtdUEzIUuK7I0E6x4f-X2GqhnURh36AJZipdqWxV-vPqG0bb-q-F3r_5L_l7UgcWbY9UDMIy4SPt8AmLll8gReU2ku6je0bb-GtVfaZ8-clO2u5ldg2qw1bhmAmNgew6PXYFZAX7zktbnKnJX4iezunTHjC9wbANlMF33_Dkd3O-b0nVXVFdafc6ru4rWmJARSPu-MZSPNMpcff9oqUoYNzkIQz5bktdM',
    ],
    [
        'slug' => 'iskcon-ujjain', 'name' => 'ISKCON Ujjain', 'deity' => 'Lord Krishna',
        'location' => 'Ujjain, Madhya Pradesh', 'category' => 'other', 'rating' => 4.7,
        'description' => 'A serene Radha-Krishna temple run by ISKCON, known for its peaceful ambience, kirtans and beautiful deities.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYRCGZDnhjZN1TAmQMqEk05aeszx3lzwigCXJILLUv0UGwOF9u6lfNo6k8FXQz7lYF9UsudcD6VJjfeHpgns-HKUBUwKYtfOMw2365BCWMwd3vnANBrE7f7R_vsXN_22nSAoHiMK6k6bkt0RA7bBN_ouK5Z9vSaUr2CUGLxJlP38gv6o6fxZodL2Tk-NkQBIagtcqKcSvAuCFarEzUWCQpyKQPuCd8w0TDW7m1MaRgCAts0QyENgfEKa_NEq2K4l_u4Cv5mzAyfD8',
    ],
    [
        'slug' => 'vaishno-devi', 'name' => 'Vaishno Devi', 'deity' => 'Mata Vaishno Devi',
        'location' => 'Katra, Jammu & Kashmir', 'category' => 'shakti-peetha', 'rating' => 4.9,
        'description' => 'A cherished hilltop shrine reached by a scenic pilgrimage trek, drawing millions of devotees each year.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBHvl-_hQYgL-qbIC8yLjmXkWD4Nf52PkxOh5Jr7Wt4qpqmkzMDMyHZEf_v2wfAyneBcVPodG0wEeC5-JFM0AlR22lA7BVWIjmqXgq1-6lySyXAs1K4aW8bsp1PG-SJgVhYFQz1wB0oFDJyYbQrBtZ9Kmoh_8fzT9vbCFbpHiIuKYLhpN6ZKYZaQycoUjv2UakPHel45ozHxk7YT04LUtW35bgNZEOFBSIWbtbr3dZrPMGpS8bPbAgT1KY0nV2cFeq8MN-2vw2H8bM',
    ],
    [
        'slug' => 'ramanathaswamy', 'name' => 'Ramanathaswamy', 'deity' => 'Lord Shiva',
        'location' => 'Rameswaram, Tamil Nadu', 'category' => 'south-indian', 'rating' => 4.8,
        'description' => 'A sacred island temple known for its magnificent corridors — the longest of any Hindu temple — and holy bathing wells.',
        'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCiJhwAu0rWUXoNGo7ED2Ka4TzsceQ7hUVRyJUeoXN8i3jeP1VE4Amq_vmRPxW7AvT4vZYpLM5l5VOomEWnn-UJnU-2GJ6voovLBXNWZkQe3Q-ECF1VPKmNRHnG4_xjbIvPERe_RkXma1i0JprfABkCu9qFoQSHeBDIoNKkGqwsTMYUG3GSQvX1KSbEOc4xcdSpAc7EyfFfrYjYVB4uFy2hPNzz3_8lGgJ-LUW_dzQCSwWs0iTekHPg6j4Tohi2HMeKvziMPvDhwX0',
    ],
];

$pdo = Connection::get();
$stmt = $pdo->prepare(
    'INSERT INTO temples (slug, name, deity, location, category, description, image_url, rating)
     VALUES (:slug, :name, :deity, :location, :category, :description, :image_url, :rating)
     ON DUPLICATE KEY UPDATE
        name = VALUES(name), deity = VALUES(deity), location = VALUES(location),
        category = VALUES(category), description = VALUES(description),
        image_url = VALUES(image_url), rating = VALUES(rating)'
);

foreach ($temples as $t) {
    $stmt->execute($t);
}

echo 'Seeded ' . count($temples) . " temples.\n";
