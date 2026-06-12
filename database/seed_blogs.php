<?php
/**
 * Seed the blog_posts table. Re-runnable (ON DUPLICATE KEY by slug).
 * Run:  php database/seed_blogs.php
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;

$img = [
    'varanasi'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCf4nTHll1gF1sPihj3LPS-f7H9p5sFpzQYxQaAVfv0iemQeoi1XxqLozeBvxp3cL9ZM5dwHDnZgPqRdQhUnav4itv_UZ--ZFLMuP92WDWe-3TMHfd7B7hvm9GWR3kWKzonS9oRd4l7IQ3InWwhPzUUtCJH6LCJUtE22rIGJ2gWwNdQLpTRGFeDegFButsvQsUUwg2TQ4wFgNRrGp3Lb9iH4O3vDlhYj6kpnnxOIwRjtnGdnIBh3ZLOMjOeacfAgg6o7Oajjb-Kg5Q',
    'architecture' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDTUCpueZArZvZVakSd-6qMoFmrYPPG4QtU-9-jCYnVx9mbsN33jrLkA6SLb2G7OBuR0kUimEj8X-NutqTFLkVYE71WeGRkTYGlaoftDLP30GTxNNNQDZ6u_0m1FBngNxIu2TXPn3DKLtCrBV3tcWApxceDyE-k9vViWuypTmE-MdiidJ0A6OsC7suQq8C3foGR0FzmI13U911bKTEh_e5fravpPaCdZpt9g_Kz_VvYqfi2hmZeb_SQi0A4NlPmVSQ4opYCE0NAWUw',
    'meditation'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAX82y3jVQj2GVZt5P1svs7lyaXqUlpHguebginyH_Jr3L3DtDIilnsW1kF88arGdSq6cfoUEOULpp2JG0tbj21Ysi2ajr59rV8oB9IoH6PhMZHzT7-73E8MLqwSCfApk_J9K2VdNwrPoOvIIRyQhcEfxHmc6EajoGrx_GX-VOAU8oLk_6t1o2bhKS8xq1a3qbkQTzzbE4uDig1JE33iwXsnlDb6Asw3OOfKhcGkCg8ghNEQfuuWSYDxCeD1ROgF5BBwY3ZTEmHnW4',
    'puja'         => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCqDeX8qBl1LicQ96cRJkWaU9ylQiX0m0TmX3p8hk8SdHUpGyASiY4U6OVt-zgphk_q_zgXJNcZfKYWQ3xjNWmfu5txm5zZfDoM75IV6UkobZFVkmVLCL8AyKpZqdLRG9vWjjPK1LXCj_9An_nOZGeojpvvKmc6T7eSvz8zW7fqPrQNnVt4iEXt1Yh-9XQU3RpUnEqI4U5ecg0hF5Qp1RoDV_MQMBSkjjlpApzVbjQUGz8sNr5LH6uQvFyKz99YjrlXn9aOh8gw5xE',
    'mountains'    => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBHvl-_hQYgL-qbIC8yLjmXkWD4Nf52PkxOh5Jr7Wt4qpqmkzMDMyHZEf_v2wfAyneBcVPodG0wEeC5-JFM0AlR22lA7BVWIjmqXgq1-6lySyXAs1K4aW8bsp1PG-SJgVhYFQz1wB0oFDJyYbQrBtZ9Kmoh_8fzT9vbCFbpHiIuKYLhpN6ZKYZaQycoUjv2UakPHel45ozHxk7YT04LUtW35bgNZEOFBSIWbtbr3dZrPMGpS8bPbAgT1KY0nV2cFeq8MN-2vw2H8bM',
];

$posts = [
    [
        'slug' => 'varanasi-arati', 'title' => 'The Significance of Varanasi Arati',
        'category' => 'Rituals', 'author' => 'Sri Ramana', 'published_at' => '2024-10-20',
        'is_featured' => 1, 'is_trending' => 0, 'image_url' => $img['varanasi'],
        'excerpt' => 'Witnessing the evening ritual at Dashashwamedh Ghat is a transformative experience. We delve into the history, symbolism, and spiritual profoundness of this daily offering to the sacred river.',
        'body' => "Each evening, as dusk settles over Varanasi, the ghats come alive with the rhythmic clang of bells and the glow of multi-tiered brass lamps. The Ganga Aarti at Dashashwamedh Ghat is more than a ceremony — it is a centuries-old dialogue between devotee and the divine river.\n\nThe ritual unfolds in precise, choreographed movements. Priests in saffron robes raise towering lamps in slow arcs, tracing sacred geometry in the air while conch shells sound across the water. Every gesture carries meaning, honouring the elements — fire, water, air, earth, and ether.\n\nFor pilgrims and travellers alike, the Aarti offers a moment of profound stillness amid the city's ancient energy. To witness it is to feel time fold inward, connecting the present moment to an unbroken lineage of devotion.",
    ],
    [
        'slug' => 'sacred-geometry', 'title' => 'Decoding the Sacred Geometry of South Indian Temples',
        'category' => 'Architecture', 'author' => 'Dr. Ananya Iyer', 'published_at' => '2024-10-12',
        'is_featured' => 0, 'is_trending' => 0, 'image_url' => $img['architecture'],
        'excerpt' => 'An exploration into the Vastu Shastra principles that guide the construction of towering Gopurams and intricate mandapams, creating spaces of resonant spiritual energy.',
        'body' => "South Indian temple architecture is a study in sacred proportion. From the soaring gopuram gateways to the inner sanctum, every measurement follows the principles of Vastu Shastra and Shilpa Shastra.\n\nThe temple is conceived as a cosmic body — the deity's chamber at its heart, surrounded by concentric layers that the devotee passes through on a symbolic inward journey. This deliberate geometry is designed to focus energy and quiet the mind.\n\nThe result is architecture that does not merely house worship but actively shapes the experience of it, guiding the visitor from the bustle of the outer world toward the silence of the divine.",
    ],
    [
        'slug' => 'art-of-stillness', 'title' => 'The Art of Stillness: Integrating Ancient Meditation into Modern Life',
        'category' => 'Wellness', 'author' => 'Maya Desai', 'published_at' => '2024-10-05',
        'is_featured' => 0, 'is_trending' => 0, 'image_url' => $img['meditation'],
        'excerpt' => 'Practical guidance on establishing a daily Dhyana practice amidst the chaos of contemporary living, drawing from centuries-old yogic texts.',
        'body' => "Meditation is often imagined as something reserved for monks and mountain caves. In truth, the yogic texts describe Dhyana as a practice woven into ordinary life — available to anyone willing to sit, breathe, and observe.\n\nBegin small. A few minutes each morning, in a quiet corner, is enough to train attention. The goal is not to empty the mind but to watch it without being swept away.\n\nOver time, this quiet discipline reshapes how we meet the world — with more patience, clarity, and a steady inner calm that no external chaos can easily disturb.",
    ],
    [
        'slug' => 'home-puja', 'title' => 'Understanding the Elements of a Home Puja',
        'category' => 'Rituals', 'author' => 'Sri Ramana', 'published_at' => '2024-09-28',
        'is_featured' => 0, 'is_trending' => 0, 'image_url' => $img['puja'],
        'excerpt' => 'A step-by-step guide to assembling your personal shrine and the symbolic meaning behind each offering made during a traditional ceremony.',
        'body' => "A home puja transforms an ordinary corner of the house into a sacred space. At its centre sits the deity, surrounded by offerings that each carry symbolic weight.\n\nThe lamp represents knowledge dispelling darkness; flowers offer beauty and impermanence; incense purifies the air and the mind. Water, fruit, and vermilion complete the simple yet profound arrangement.\n\nWhat matters most is intention. Performed with sincerity, even the simplest home ritual becomes a daily anchor of devotion and gratitude.",
    ],
    [
        'slug' => 'kumbh-mela', 'title' => 'The Mysticism of the Kumbh Mela Gathering',
        'category' => 'Traditions', 'author' => 'Dr. Ananya Iyer', 'published_at' => '2024-09-15',
        'is_featured' => 0, 'is_trending' => 1, 'image_url' => $img['varanasi'],
        'excerpt' => 'The largest peaceful gathering on earth, the Kumbh Mela draws millions to the sacred riverbanks in search of liberation.',
        'body' => "Every twelve years, tens of millions of pilgrims converge on the confluence of sacred rivers for the Kumbh Mela — the largest peaceful gathering humanity has ever known.\n\nThe festival's roots lie in the ancient legend of the churning of the ocean, when drops of the nectar of immortality fell at four earthly sites. Bathing in these waters during the Mela is believed to cleanse lifetimes of karma.\n\nBeyond the scale and spectacle lies something quieter: a shared human longing for renewal, expressed through one of the world's oldest living traditions.",
    ],
    [
        'slug' => 'char-dham-guide', 'title' => 'Preparing for the Char Dham Yatra: A Spiritual Guide',
        'category' => 'Pilgrimage', 'author' => 'Vikram Singh', 'published_at' => '2024-09-02',
        'is_featured' => 0, 'is_trending' => 1, 'image_url' => $img['mountains'],
        'excerpt' => 'Everything you need to know — physically and spiritually — before undertaking the sacred Himalayan circuit of four holy shrines.',
        'body' => "The Char Dham Yatra — Yamunotri, Gangotri, Kedarnath, and Badrinath — is among the most revered pilgrimages in the Himalayas. Preparation is both practical and inward.\n\nPhysically, the high-altitude trails demand fitness, gradual acclimatisation, and the right gear. Spiritually, pilgrims are encouraged to approach the journey with humility and an open heart.\n\nThose who complete the circuit often describe it not as a destination reached, but as a transformation undergone — the mountains stripping away the noise until only devotion remains.",
    ],
    [
        'slug' => 'advaita-vedanta', 'title' => 'Advaita Vedanta Explained Simply for the Modern Seeker',
        'category' => 'Philosophy', 'author' => 'Sri Ramana', 'published_at' => '2024-08-21',
        'is_featured' => 0, 'is_trending' => 1, 'image_url' => $img['meditation'],
        'excerpt' => 'A clear introduction to the non-dual philosophy at the heart of much of Hindu thought — and what it means for everyday life.',
        'body' => "Advaita Vedanta, the philosophy of non-duality, teaches that the individual self and the ultimate reality are not separate but one. It is a profound idea, yet its essence is surprisingly simple.\n\nThe apparent separateness we experience — between self and world, subject and object — is, in this view, a kind of misperception. Liberation comes from seeing through it to the unity beneath.\n\nFor the modern seeker, Advaita is less a belief to adopt than an invitation to inquire: to ask, gently and persistently, 'Who am I?' until the question dissolves the questioner.",
    ],
];

$pdo  = Connection::get();
$stmt = $pdo->prepare(
    'INSERT INTO blog_posts (slug, title, excerpt, body, category, author, image_url, published_at, is_featured, is_trending)
     VALUES (:slug, :title, :excerpt, :body, :category, :author, :image_url, :published_at, :is_featured, :is_trending)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), excerpt = VALUES(excerpt), body = VALUES(body),
        category = VALUES(category), author = VALUES(author), image_url = VALUES(image_url),
        published_at = VALUES(published_at), is_featured = VALUES(is_featured), is_trending = VALUES(is_trending)'
);

foreach ($posts as $p) {
    $stmt->execute($p);
}

echo 'Seeded ' . count($posts) . " blog posts.\n";
