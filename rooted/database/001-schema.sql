-- Schema
-- This script is executed when bootstrapping the database for the first time.
-- After changes, destroy the MySQL volume and recreate the container:
--   docker compose down -v && docker compose up

CREATE DATABASE IF NOT EXISTS `rooted`
    -- TODO: Explain CHARACTER SET.
    CHARACTER SET utf8mb4
    -- TODO: Explain COLLATE.
    COLLATE utf8mb4_unicode_ci;

USE `rooted`;

-- Users
CREATE TABLE IF NOT EXISTS `users` (
    `id`                    INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `email`                 VARCHAR(255)    NOT NULL,
    `password`              VARCHAR(255)    NOT NULL,
    `role`                  ENUM('admin', 'moderator', 'user', 'guest') NOT NULL DEFAULT 'user',
    `two_factor_code`       VARCHAR(6)      DEFAULT NULL,
    `two_factor_expires_at` DATETIME        DEFAULT NULL,
    `email_verified`        TINYINT(1)      NOT NULL DEFAULT 0,
    `created_at`            TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_users_email` (`email`)
    -- TODO: Explain ENGINE.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Plants
CREATE TABLE IF NOT EXISTS `plants` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id`       INT UNSIGNED    NOT NULL,
    `name`          VARCHAR(255)    NOT NULL,
    `body`          TEXT            DEFAULT NULL,
    `visibility`    ENUM('public', 'internal') NOT NULL DEFAULT 'public',
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    KEY `idx_plants_user_id` (`user_id`),
    CONSTRAINT `fk_plants_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Media
CREATE TABLE IF NOT EXISTS `media` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `plant_id`      INT UNSIGNED    NOT NULL,
    `type`          ENUM('image', 'video', 'audio') NOT NULL,
    `path`          VARCHAR(500)    NOT NULL,
    `filename`      VARCHAR(255)    NOT NULL,
    `mime_type`     VARCHAR(100)    NOT NULL,
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    KEY `idx_media_plant_id` (`plant_id`),
    CONSTRAINT `fk_media_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tags
CREATE TABLE IF NOT EXISTS `tags` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(100)    NOT NULL,
    `type`          ENUM('primary', 'secondary') NOT NULL,
    `user_id`       INT UNSIGNED    NOT NULL,
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_tags_name` (`name`),
    KEY `idx_tags_user_id` (`user_id`),
    CONSTRAINT `fk_tags_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Plant <-> Tag  (many-to-many)
CREATE TABLE IF NOT EXISTS `plant_tag` (
    `plant_id`  INT UNSIGNED NOT NULL,
    `tag_id`    INT UNSIGNED NOT NULL,

    PRIMARY KEY (`plant_id`, `tag_id`),
    KEY `idx_plant_tag_tag_id` (`tag_id`),
    CONSTRAINT `fk_plant_tag_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_plant_tag_tag`   FOREIGN KEY (`tag_id`)   REFERENCES `tags`   (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Plant Meta  (key-value pairs)
CREATE TABLE IF NOT EXISTS `plant_meta` (
    `id`        INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `plant_id`  INT UNSIGNED    NOT NULL,
    `key`       VARCHAR(100)    NOT NULL,
    `value`     VARCHAR(255)    NOT NULL,

    PRIMARY KEY (`id`),
    KEY `idx_plant_meta_plant_id` (`plant_id`),
    CONSTRAINT `fk_plant_meta_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Subscriptions  (user subscribes to tag)
CREATE TABLE IF NOT EXISTS `subscriptions` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id`       INT UNSIGNED    NOT NULL,
    `tag_id`        INT UNSIGNED    NOT NULL,
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_subscriptions_user_tag` (`user_id`, `tag_id`),
    KEY `idx_subscriptions_tag_id` (`tag_id`),
    CONSTRAINT `fk_subscriptions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_subscriptions_tag`  FOREIGN KEY (`tag_id`)  REFERENCES `tags`  (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Settings  (application configuration key-value store)
CREATE TABLE IF NOT EXISTS `settings` (
    `id`    INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `key`   VARCHAR(100)    NOT NULL,
    `value` TEXT            DEFAULT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_settings_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
