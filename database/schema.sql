-- ALPHA Global Shipping & Logistics — database schema
-- Import:  mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS alpha_gsl CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE alpha_gsl;

CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('admin','editor') NOT NULL DEFAULT 'editor',
    last_login    DATETIME NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
    id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS posts (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title            VARCHAR(200) NOT NULL,
    slug             VARCHAR(220) NOT NULL UNIQUE,
    excerpt          VARCHAR(400) NULL,
    content          LONGTEXT NOT NULL,
    featured_image   VARCHAR(100) NULL,
    category_id      INT UNSIGNED NULL,
    author_id        INT UNSIGNED NULL,
    status           ENUM('draft','published') NOT NULL DEFAULT 'draft',
    meta_title       VARCHAR(70) NULL,
    meta_description VARCHAR(170) NULL,
    published_at     DATETIME NULL,
    created_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status_pub (status, published_at),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id)   REFERENCES users(id)      ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS queries (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type           ENUM('contact','quote') NOT NULL,
    name           VARCHAR(100) NOT NULL,
    email          VARCHAR(150) NOT NULL,
    phone          VARCHAR(30)  NULL,
    company        VARCHAR(150) NULL,
    subject        VARCHAR(200) NULL,
    message        TEXT NULL,
    service_type   VARCHAR(50)  NULL,
    origin         VARCHAR(150) NULL,
    destination    VARCHAR(150) NULL,
    commodity      VARCHAR(200) NULL,
    weight_kg      DECIMAL(12,2) NULL,
    volume_cbm     DECIMAL(12,2) NULL,
    container_type VARCHAR(30)  NULL,
    incoterms      VARCHAR(10)  NULL,
    ship_date      DATE NULL,
    status         ENUM('new','in_progress','closed') NOT NULL DEFAULT 'new',
    admin_notes    TEXT NULL,
    ip_address     VARCHAR(45) NOT NULL,
    created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_ip_time (ip_address, created_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS shipments (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tracking_no    VARCHAR(40) NOT NULL UNIQUE,
    customer_name  VARCHAR(150) NULL,
    origin         VARCHAR(150) NOT NULL,
    destination    VARCHAR(150) NOT NULL,
    mode           ENUM('Ocean','Air','Land') NOT NULL DEFAULT 'Ocean',
    current_status VARCHAR(100) NOT NULL DEFAULT 'Booking Confirmed',
    eta            DATE NULL,
    created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS shipment_events (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT UNSIGNED NOT NULL,
    status      VARCHAR(100) NOT NULL,
    location    VARCHAR(150) NULL,
    note        VARCHAR(300) NULL,
    event_time  DATETIME NOT NULL,
    INDEX idx_shipment (shipment_id, event_time),
    FOREIGN KEY (shipment_id) REFERENCES shipments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS settings (
    `key`   VARCHAR(60) PRIMARY KEY,
    `value` TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS login_attempts (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address   VARCHAR(45) NOT NULL,
    email        VARCHAR(150) NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip (ip_address, attempted_at),
    INDEX idx_email (email, attempted_at)
) ENGINE=InnoDB;
