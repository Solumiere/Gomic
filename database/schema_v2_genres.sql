-- Gomic: интернет-магазин комиксов (MySQL 8.4)
-- Схема БД v2: добавлены жанры + более понятные названия сущностей.
-- Роли: user/admin через users.is_admin
-- Правила приложения:
-- - скачать PDF и оставить отзыв можно только при наличии paid/completed заказа с данным комиксом.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS review_votes;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS comic_book_genre;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS comic_books;
DROP TABLE IF EXISTS users;

-- Пользователи
CREATE TABLE users (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  email_verified_at DATETIME NULL,
  password VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  remember_token VARCHAR(100) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email),
  KEY idx_users_is_admin (is_admin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Комиксы (товары)
CREATE TABLE comic_books (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL,
  description TEXT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  cover_image_path VARCHAR(255) NULL,
  pdf_path VARCHAR(255) NOT NULL,
  pages_count INT UNSIGNED NULL,
  published_year SMALLINT UNSIGNED NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_comic_books_slug (slug),
  KEY idx_comic_books_price (price),
  KEY idx_comic_books_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Жанры
CREATE TABLE genres (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(80) NOT NULL,
  slug VARCHAR(100) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_genres_name (name),
  UNIQUE KEY uq_genres_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Связь многие-ко-многим: комиксы ↔ жанры
CREATE TABLE comic_book_genre (
  comic_book_id BIGINT UNSIGNED NOT NULL,
  genre_id BIGINT UNSIGNED NOT NULL,
  created_at DATETIME NULL,
  PRIMARY KEY (comic_book_id, genre_id),
  KEY idx_cbg_genre (genre_id),
  CONSTRAINT fk_cbg_comic_book
    FOREIGN KEY (comic_book_id) REFERENCES comic_books(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_cbg_genre
    FOREIGN KEY (genre_id) REFERENCES genres(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Заказы
CREATE TABLE orders (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  status ENUM('created','paid','cancelled','completed') NOT NULL DEFAULT 'created',
  total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  payment_method VARCHAR(40) NULL,
  paid_at DATETIME NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  KEY idx_orders_user_status (user_id, status),
  KEY idx_orders_created_at (created_at),
  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Позиции заказа
CREATE TABLE order_items (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id BIGINT UNSIGNED NOT NULL,
  comic_book_id BIGINT UNSIGNED NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  qty INT UNSIGNED NOT NULL DEFAULT 1,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_order_items_order_comic_book (order_id, comic_book_id),
  KEY idx_order_items_comic_book (comic_book_id),
  CONSTRAINT fk_order_items_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_order_items_comic_book
    FOREIGN KEY (comic_book_id) REFERENCES comic_books(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Отзывы к комиксам
CREATE TABLE reviews (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  comic_book_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  rating TINYINT UNSIGNED NOT NULL,
  body TEXT NOT NULL,
  is_hidden TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5),
  UNIQUE KEY uq_reviews_user_comic_book (user_id, comic_book_id),
  KEY idx_reviews_comic_book_created (comic_book_id, created_at),
  KEY idx_reviews_hidden (is_hidden),
  CONSTRAINT fk_reviews_comic_book
    FOREIGN KEY (comic_book_id) REFERENCES comic_books(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_reviews_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Голоса полезности отзывов (опционально)
CREATE TABLE review_votes (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  review_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  vote ENUM('up','down') NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_review_votes_review_user (review_id, user_id),
  KEY idx_review_votes_review (review_id),
  CONSTRAINT fk_review_votes_review
    FOREIGN KEY (review_id) REFERENCES reviews(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_review_votes_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
