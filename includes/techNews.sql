-- 1️⃣ Tạo database
CREATE DATABASE IF NOT EXISTS TechNews
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE TechNews;

-- 2️⃣ Bảng USER
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL,
    role BOOLEAN DEFAULT FALSE,  -- TRUE = admin, FALSE = user
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3️⃣ Bảng CATEGORY
CREATE TABLE category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- 4️⃣ Bảng NEWS
CREATE TABLE news (
    news_id INT AUTO_INCREMENT PRIMARY KEY,
    news_title VARCHAR(255) NOT NULL,
    news_description TEXT,
    news_image VARCHAR(255),   -- đường dẫn ảnh
    sumary TEXT,
    post_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    image_note VARCHAR(255),
    views INT DEFAULT 0,
    isPost BOOLEAN DEFAULT FALSE,
    user_id INT,
    category_id INT,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE SET NULL ON UPDATE CASCADE
);
