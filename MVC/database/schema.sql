-- Online Food Blog – shared schema (Project 07)
-- Source of truth: Group_7_S.pdf "Shared Database Schema"
-- DO NOT drop or ALTER these tables once feature branches are open.

CREATE DATABASE IF NOT EXISTS online_food_blog
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE online_food_blog;

-- 1. users
CREATE TABLE users (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100)  NOT NULL,
    email           VARCHAR(150)  NOT NULL UNIQUE,
    password_hash   VARCHAR(255)  NOT NULL,
    role            ENUM('admin','member') NOT NULL DEFAULT 'member',
    profile_picture VARCHAR(255)  DEFAULT NULL,
    remember_token  VARCHAR(255)  DEFAULT NULL,  -- Task 1: "Remember Me" hashed token
    created_at      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. restaurants
CREATE TABLE restaurants (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name             VARCHAR(150) NOT NULL,
    location         VARCHAR(150) NOT NULL,
    area             VARCHAR(150) NOT NULL,
    short_background TEXT,
    goals            TEXT,
    created_at       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_restaurants_location (location),
    INDEX idx_restaurants_area     (area)
) ENGINE=InnoDB;

-- 3. menu_items
CREATE TABLE menu_items (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT UNSIGNED  NOT NULL,
    name          VARCHAR(150)  NOT NULL,
    description   TEXT,
    price         DECIMAL(10,2) NOT NULL CHECK (price > 0),
    image_path    VARCHAR(255),
    created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_menu_restaurant
        FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE,
    INDEX idx_menu_restaurant (restaurant_id),
    INDEX idx_menu_name       (name)
) ENGINE=InnoDB;

-- 4. reviews  (comments on food items)
CREATE TABLE reviews (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    menu_item_id INT UNSIGNED NOT NULL,
    user_id      INT UNSIGNED NOT NULL,
    comment      TEXT NOT NULL,
    created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reviews_menu FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE,
    CONSTRAINT fk_reviews_user FOREIGN KEY (user_id)      REFERENCES users(id)      ON DELETE CASCADE,
    INDEX idx_reviews_menu (menu_item_id),
    INDEX idx_reviews_user (user_id)
) ENGINE=InnoDB;

-- 5. food_experience_posts
CREATE TABLE food_experience_posts (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id       INT UNSIGNED NOT NULL,
    title         VARCHAR(200) NOT NULL,
    content       TEXT         NOT NULL,
    post_type     ENUM('restaurant','food','both') NOT NULL,
    restaurant_id INT UNSIGNED DEFAULT NULL,
    menu_item_id  INT UNSIGNED DEFAULT NULL,
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fep_user       FOREIGN KEY (user_id)       REFERENCES users(id)       ON DELETE CASCADE,
    CONSTRAINT fk_fep_restaurant FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE SET NULL,
    CONSTRAINT fk_fep_menu       FOREIGN KEY (menu_item_id)  REFERENCES menu_items(id)  ON DELETE SET NULL,
    INDEX idx_fep_user (user_id),
    INDEX idx_fep_type (post_type)
) ENGINE=InnoDB;

-- 6. food_experience_comments
CREATE TABLE food_experience_comments (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id    INT UNSIGNED NOT NULL,
    user_id    INT UNSIGNED NOT NULL,
    comment    TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_fec_post FOREIGN KEY (post_id) REFERENCES food_experience_posts(id) ON DELETE CASCADE,
    CONSTRAINT fk_fec_user FOREIGN KEY (user_id) REFERENCES users(id)                 ON DELETE CASCADE,
    INDEX idx_fec_post (post_id),
    INDEX idx_fec_user (user_id)
) ENGINE=InnoDB;
