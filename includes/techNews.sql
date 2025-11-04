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
    user_status BOOLEAN DEFAULT FALSE, 
    user_forget_token VARCHAR(500), 
    user_active_token VARCHAR(500),  
    user_created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO user (user_email, user_password, user_name, user_role, user_status) VALUES ("nva@gmail.com", md5("nva123"), "Nguyen Van A", FALSE, TRUE);
INSERT INTO user (user_email, user_password, user_name, user_role, user_status) VALUES ("admin@gmail.com", md5("admin123"), "Administrator", TRUE, TRUE);

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
INSERT INTO news 
(news_title, news_summary, news_description, news_image_path, news_image_note, news_isPost, user_id, category_id)
VALUES
-- 1. Breaking News
('Massive Storm Hits Coastal City',
 'A powerful storm has caused severe flooding in coastal areas, forcing thousands of residents to evacuate.',
 'A massive tropical storm struck the eastern coastline early this morning, bringing with it torrential rain and powerful winds that exceeded 120 kilometers per hour.\n\nLocal authorities have issued immediate evacuation orders in low-lying areas as water levels continue to rise. Emergency shelters have been set up in schools and public buildings to accommodate displaced residents.\n\nMeteorologists warn that the storm could intensify over the next 24 hours before gradually moving inland. Rescue operations are ongoing as teams work around the clock to assist affected families and restore essential services.',
 'images/storm.jpg',
 'Photo of the flooded city streets after the storm',
 TRUE, 1, 1),

-- 2. World
('Global Leaders Meet for Climate Summit',
 'World leaders gathered in Paris to discuss urgent measures to address the escalating climate crisis.',
 'The 2025 Global Climate Summit opened today in Paris, drawing leaders from over 70 countries to discuss the growing impacts of global warming.\n\nIn his opening remarks, the UN Secretary-General emphasized the importance of collective action and urged nations to commit to stricter emission targets. Several countries announced new pledges to phase out fossil fuels by 2040.\n\nEnvironmental activists rallied outside the venue, demanding greater accountability from major polluters. The summit is expected to last for three days, with discussions focused on renewable energy, deforestation, and ocean protection.',
 'images/climate_summit.jpg',
 'Leaders attending the Climate Summit 2025 in Paris',
 TRUE, 1, 2),

-- 3. Business
('Tech Stocks Rally as Markets Recover',
 'The global stock market rebounded as investors regained confidence in major technology firms.',
 'After weeks of volatility, global stock markets rallied today, driven largely by strong earnings reports from leading tech companies like Meta, Google, and Microsoft.\n\nAnalysts credit the recovery to renewed investor optimism and better-than-expected performance across the AI and semiconductor sectors. The NASDAQ rose 2.3%, marking its strongest daily gain this quarter.\n\nDespite the positive momentum, experts caution that uncertainty remains due to inflation concerns and shifting global trade policies. Investors are advised to remain selective in the coming weeks as market trends stabilize.',
 'images/stock_market.jpg',
 'Stock market chart showing an upward trend',
 TRUE, 1, 3),

-- 4. Sports
('Local Team Wins National Championship',
 'In a stunning upset, the underdog local football team claimed the national title for the first time in 15 years.',
 'Thousands of fans flooded the streets last night as the city’s football team secured a dramatic 3–2 victory in the national championship final.\n\nThe match was an emotional rollercoaster, with both teams exchanging goals until a decisive strike in the 88th minute sealed the win. The team’s coach praised his players for their determination and teamwork throughout the season.\n\nCelebrations are expected to continue through the weekend, with the city planning a parade to honor the players and staff. Local businesses have also joined in, offering free merchandise and discounts to celebrate the victory.',
 'images/championship.jpg',
 'Team lifting the championship trophy',
 TRUE, 1, 4),

-- 5. Technology
('AI Revolutionizes Software Development',
 'Developers are now using AI-assisted tools to accelerate code generation and boost productivity.',
 'Artificial Intelligence is rapidly transforming the software industry. Developers worldwide are adopting AI-driven platforms that can generate, review, and optimize code with unprecedented accuracy.\n\nAccording to a recent study by TechWorld Analytics, more than 60% of development teams have integrated at least one AI-powered tool into their workflow. This shift has led to faster project delivery and improved code quality.\n\nExperts predict that within the next two years, AI will become an indispensable assistant for programmers, much like the rise of compilers in the 1970s. However, concerns about over-reliance on automation and data privacy still remain key challenges.',
 'images/ai_coding.jpg',
 'Developer using AI-assisted coding platform',
 TRUE, 1, 5),

-- 6. Health
('New Vaccine Shows Promising Results',
 'A groundbreaking vaccine has demonstrated 95% effectiveness in large-scale trials.',
 'Researchers at the Global Health Institute have announced promising results for a new vaccine targeting a recently emerged virus strain. The trials involved over 30,000 participants across five countries.\n\nPreliminary data indicates the vaccine achieved a 95% success rate in preventing infection, with minimal side effects reported. Health officials are now working closely with pharmaceutical companies to begin mass production.\n\nExperts believe this development marks a significant milestone in global health preparedness, potentially preventing future pandemics of similar nature.',
 'images/vaccine.jpg',
 'Scientists working in a medical lab',
 TRUE, 1, 6),

-- 7. Science
('Astronomers Discover Potentially Habitable Planet',
 'A newly discovered exoplanet may be capable of supporting life as we know it.',
 'Astronomers from NASA have identified a planet orbiting a star similar to the Sun, located 1,200 light-years from Earth. Named Kepler-452c, the planet lies within the star’s habitable zone — the region where liquid water could exist on the surface.\n\nThe discovery was made using data from the Kepler Space Telescope and has sparked excitement in the scientific community. Further analysis will focus on the planet’s atmosphere and surface conditions.\n\nWhile it’s too early to confirm whether life exists there, scientists say this finding brings humanity one step closer to understanding our place in the universe.',
 'images/exoplanet.jpg',
 'Artistic impression of the newly discovered exoplanet',
 TRUE, 1, 7),

-- 8. Entertainment
('Famous Singer Releases New Album',
 'Pop icon Lily Monroe’s new album “Skyline Dreams” dominates streaming charts worldwide.',
 'Pop superstar Lily Monroe has once again taken the world by storm with her highly anticipated album “Skyline Dreams.” Within hours of its release, the album topped Spotify and Apple Music charts in over 30 countries.\n\nThe record features 12 tracks blending electronic pop with heartfelt ballads. Critics have praised Monroe’s mature sound and introspective lyrics that explore themes of growth, nostalgia, and resilience.\n\nFans have flooded social media with excitement, sharing clips and reviews under the hashtag #SkylineDreams. A world tour has also been announced, set to begin in Tokyo this December.',
 'images/album_release.jpg',
 'Cover art of Skyline Dreams album',
 TRUE, 1, 8);
