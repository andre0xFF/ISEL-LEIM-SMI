-- =============================================================================
-- Rooted — Database Bootstrap
-- =============================================================================
-- This script is executed automatically when the MySQL container starts for
-- the first time (mounted into /docker-entrypoint-initdb.d/).
-- =============================================================================

CREATE DATABASE IF NOT EXISTS `rooted`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `rooted`;

-- -----------------------------------------------------------------------------
-- Users
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`              INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    `email`           VARCHAR(255)   NOT NULL,
    `password`        VARCHAR(255)   NOT NULL,
    `role`            ENUM('admin', 'user', 'sympathizer', 'guest') NOT NULL DEFAULT 'user',
    `two_factor_code` VARCHAR(6)     DEFAULT NULL,
    `two_factor_expires_at` DATETIME DEFAULT NULL,
    `email_verified`  TINYINT(1)     NOT NULL DEFAULT 0,
    `created_at`      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- Plants
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `plants` (
    `id`              INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    `user_id`         INT UNSIGNED   NOT NULL,
    `name`            VARCHAR(255)   NOT NULL,
    `body`            TEXT           DEFAULT NULL,
    `category`        VARCHAR(100)   DEFAULT NULL,
    `subcategory`     VARCHAR(100)   DEFAULT NULL,
    `image_path`      VARCHAR(500)   DEFAULT NULL,
    `created_at`      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_plants_user_id` (`user_id`),
    CONSTRAINT `fk_plants_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- Seed — admin user (password: "password")
-- -----------------------------------------------------------------------------
INSERT INTO `users` (`email`, `password`, `role`, `email_verified`) VALUES
    ('admin@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1);
