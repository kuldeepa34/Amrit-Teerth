-- ============================================================
--  SacredPath — database schema
--  Import locally:   mysql -u root -p < database/schema.sql
--  On Hostinger:     paste into phpMyAdmin > SQL tab
-- ============================================================

CREATE DATABASE IF NOT EXISTS `sacredpath`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `sacredpath`;

-- ------------------------------------------------------------
--  Newsletter subscribers (footer + blog sidebar signup)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email`         VARCHAR(255) NOT NULL,
    `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Users (authentication)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(150) NOT NULL,
    `email`         VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Temples
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `temples` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug`        VARCHAR(160) NOT NULL,
    `name`        VARCHAR(200) NOT NULL,
    `deity`       VARCHAR(150) DEFAULT NULL,
    `location`    VARCHAR(200) NOT NULL,
    `category`    VARCHAR(40)  NOT NULL DEFAULT 'other',
    `description` TEXT NOT NULL,
    `image_url`   TEXT NOT NULL,
    `rating`      DECIMAL(2,1) NOT NULL DEFAULT 5.0,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_slug` (`slug`),
    KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Blog posts
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug`         VARCHAR(180) NOT NULL,
    `title`        VARCHAR(255) NOT NULL,
    `excerpt`      TEXT NOT NULL,
    `body`         MEDIUMTEXT NOT NULL,
    `category`     VARCHAR(60) NOT NULL,
    `author`       VARCHAR(120) NOT NULL DEFAULT 'SacredPath',
    `image_url`    TEXT NOT NULL,
    `published_at` DATE NOT NULL,
    `is_featured`  TINYINT(1) NOT NULL DEFAULT 0,
    `is_trending`  TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_slug` (`slug`),
    KEY `idx_category` (`category`),
    KEY `idx_featured` (`is_featured`),
    KEY `idx_trending` (`is_trending`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Darshan offerings
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `darshan_offerings` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug`        VARCHAR(160) NOT NULL,
    `temple_name` VARCHAR(200) NOT NULL,
    `location`    VARCHAR(200) NOT NULL,
    `category`    VARCHAR(40)  NOT NULL DEFAULT 'daily-darshan',
    `image_url`   TEXT NOT NULL,
    `rating`      DECIMAL(2,1) NOT NULL DEFAULT 5.0,
    `schedule`    JSON NOT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_slug` (`slug`),
    KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Bookings (darshan)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`       INT UNSIGNED NOT NULL,
    `offering_id`   INT UNSIGNED NOT NULL,
    `offering_name` VARCHAR(200) NOT NULL,
    `slot_name`     VARCHAR(120) NOT NULL,
    `slot_time`     VARCHAR(40)  NOT NULL,
    `booking_date`  DATE NOT NULL,
    `devotees`      INT UNSIGNED NOT NULL DEFAULT 1,
    `status`        VARCHAR(20)  NOT NULL DEFAULT 'confirmed',
    `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user` (`user_id`),
    CONSTRAINT `fk_bookings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Contact form messages
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `full_name`        VARCHAR(150) NOT NULL,
    `email`            VARCHAR(255) NOT NULL,
    `service_interest` VARCHAR(50)  DEFAULT NULL,
    `message`          TEXT NOT NULL,
    `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
