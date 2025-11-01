-- 1️⃣ Tạo database
DROP DATABASE IF EXISTS TechNews;

CREATE DATABASE IF NOT EXISTS TechNews
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE TechNews;

-- 2️⃣ Bảng USER
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(150) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    user_role BOOLEAN DEFAULT FALSE,  -- TRUE = admin, FALSE = user
    user_created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO user (user_email, user_password, user_name, user_role) VALUES ("nva@gmail.com", md5("nva123"), "Nguyen Van A", FALSE);
INSERT INTO user (user_email, user_password, user_name, user_role) VALUES ("admin@gmail.com", md5("admin123"), "Administrator", TRUE);

-- 3️⃣ Bảng CATEGORY
CREATE TABLE category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);
INSERT INTO category (category_name) VALUES ("Breaking News"), ("World"), ("Business"), ("Sports"), ("Technology"), ("Health"), ("Science"), ("Entertainment");

-- 4️⃣ Bảng NEWS
CREATE TABLE news (
    news_id INT AUTO_INCREMENT PRIMARY KEY,
    news_title VARCHAR(255) NOT NULL,
    news_summary TEXT,
    news_description TEXT,
    news_post_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    news_image_path VARCHAR(255),   -- đường dẫn ảnh
    news_image_note VARCHAR(255),
    news_views INT DEFAULT 0,
    news_isPost BOOLEAN DEFAULT FALSE,
    user_id INT,
    category_id INT,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO news (news_title, news_summary, news_description, news_image_path, news_image_note, user_id, category_id) 
VALUES (
    'AI technology booming in 2025',
    'Many companies invest heavily in AI to boost productivity.',
    'According to the latest report, the AI field is growing faster than ever. Big tech firms like Google, OpenAI, and Microsoft are expanding their AI products aggressively.',
    'templates/assets/images/add_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg',
    'Illustration of AI technology',
    1,
    2
);

INSERT INTO news (news_title, news_summary, news_description, news_image_path, news_image_note, user_id, category_id)
VALUES (
    'Global markets rally amid economic optimism',
    'Stock markets worldwide see significant gains as economic outlook improves.',
    'Investors are showing increased confidence in the global economy, leading to a surge in stock prices across major exchanges. Analysts attribute this to positive economic data and successful vaccination campaigns.',
    'templates/assets/images/logo.png',
    'Stock market graph showing upward trend',
    1,
    3
);
