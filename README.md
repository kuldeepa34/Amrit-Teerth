# Amrit Teerth

A modern temple experience platform — book darshan, puja services, temple
experiences, and spiritual offerings. Built with **vanilla PHP** (no frameworks).

## Project structure

```
.
├── public/                 # Web root — point your server here
│   ├── index.php           # Home entry point (thin)
│   └── assets/
│       ├── css/custom.css  # Styles Tailwind utilities can't express
│       ├── js/             # Page scripts
│       └── images/         # Local image assets
├── views/
│   └── pages/
│       └── home.php        # Home page content (<main> only)
├── includes/               # Reusable view partials (outside web root)
│   ├── layout.php          # Base layout — wraps a view in head/header/footer
│   ├── head.php            # <head> + Tailwind config  (set $pageTitle)
│   ├── header.php          # Top nav + mobile bottom nav (set $activeNav)
│   └── footer.php          # Footer + closing tags
├── config/
│   └── config.php          # Site constants + nav/footer data
└── README.md
```

## How a page is built

**Entry points stay tiny.** Each `public/*.php` file just sets metadata and
points the layout at its view:

```php
// public/services.php
require __DIR__ . '/../config/config.php';
$pageTitle   = SITE_NAME . ' - Services';
$activeNav   = 'services';                          // highlights the nav link
$contentView = __DIR__ . '/../views/pages/services.php';
require __DIR__ . '/../includes/layout.php';
```

**Views hold only the page's own markup** (`<main>…</main>`):

```php
// views/pages/services.php
<main> ... page content ... </main>
```

The layout (`includes/layout.php`) renders `head → header → [view] → footer`,
so the chrome is never repeated. Any backend logic (DB queries, form handling)
goes in the entry file, above the layout require.

## Styling

- Tailwind CSS via CDN, with a custom theme (colors, spacing, fonts) defined in
  `includes/head.php`.
- Fonts: *Libre Caslon Text* (headings) + *Manrope* (body), Material Symbols icons.
- Mobile-first; responsive for tablet and desktop.

## Running locally

```bash
php -S localhost:8000 -t public
```

Then open http://localhost:8000
