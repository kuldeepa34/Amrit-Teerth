# SacredPath — Build Roadmap

Tracking the features that need backend logic. Built step by step.

## ✅ Step 1 — Backend foundation
- [x] MariaDB + PHP `pdo_mysql` + Composer installed
- [x] Composer PSR-4 autoloading (`App\` → `src/`)
- [x] `config/database.php` (outside web root, env-aware)
- [x] `src/Database/Connection.php` (shared PDO)
- [x] `database/schema.sql` + `database/setup.sql` (DB + dedicated `sacredpath` user)

## ✅ Step 2 — Form handlers
- [x] `newsletter.php` — footer + blog sidebar signup → `newsletter_subscribers`
- [x] `contact-submit.php` — contact form → `contact_messages`
- [x] CSRF protection (`App\Support\Csrf`)
- [x] Flash messages / Post-Redirect-Get (`App\Support\Flash`, `App\Support\Http`)
- [x] Server-side validation + prepared statements

## ✅ Step 3 — Auth
- [x] `users` table + bcrypt password hashing (`App\Models\User`)
- [x] `App\Support\Auth` (attempt/login/logout/check/user, session-fixation safe)
- [x] `login.php`, `register.php`, `logout.php` (+ views, CSRF, validation)
- [x] Header shows "Hi, {name}" + Logout when signed in, else Login

## 🔄 Step 4 — Data-driven content (one section at a time)
### Temples ✅
- [x] `temples` table + seeder (`database/seed_temples.php`, 9 temples)
- [x] `App\Models\Temple` (list / count / search / findBySlug)
- [x] Temples page reads from DB — category filter, search, Load More
- [x] `temple-details.php` (single temple, 404 on unknown slug)
- [ ] (later) Pilgrimage Routes table — still static for now
### Blogs ✅
- [x] `blog_posts` table + seeder (`database/seed_blogs.php`, 7 posts)
- [x] `App\Models\BlogPost` (featured / list / count / trending / topics / findBySlug)
- [x] Blogs page from DB — featured hero, topic filter, Load More, trending, topic counts
- [x] `blog-post.php` (single article, paragraphs, 404 on unknown slug)
### Darshan ✅
- [x] `darshan_offerings` table (+ JSON schedule) + seeder (7 offerings)
- [x] `App\Models\DarshanOffering` (list / count / category filter)
- [x] Darshan page from DB — tab filter, schedule rows, Load More
- [ ] "Check Availability" button → wire in Step 5 (booking)

## ✅ Step 5 — Booking flow
- [x] `bookings` table (FK to users) + `App\Models\Booking`
- [x] `booking.php` — login-gated; pick offering → date → slot → devotees → confirm
- [x] Live slot dropdown (`assets/js/booking.js`) + server-rendered fallback
- [x] CSRF + validation (valid offering/slot, date today+, 1–10 devotees)
- [x] "Your Recent Bookings" list; login/register return to intended page
- [x] Wired CTAs: Check Availability (pre-selects offering), Book Darshan Now, Start Your Journey
- [ ] (later) Header "Book Service" still → services.php (generic entry point)

## ✅ Step 6 — Polish
- [x] Config-driven social links (`$SOCIAL_LINKS`) wired into the contact page
- [x] Email delivery via PHPMailer (`App\Support\Mailer`, `config/mail.php`) —
      contact notification + newsletter welcome; no-op until SMTP is configured,
      DB storage always happens
- [x] Removed all dangling `?type`/`?route` links — service cards now have
      anchors (#puja/#sankalp/#donations/#pilgrimage); CTAs point to real
      destinations (contact/booking/darshan)

## To enable on Hostinger
- Import `database/schema.sql` (or run the per-table seeders) in phpMyAdmin
- Set DB creds in `config/database.php`; SMTP creds in `config/mail.php`
- Upload the project INCLUDING `vendor/` (no composer install on server)
- Update `$SOCIAL_LINKS` hrefs in `config/config.php` to the real profiles
