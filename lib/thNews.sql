-- 1️⃣ Tạo database
DROP DATABASE IF EXISTS THNews;

CREATE DATABASE IF NOT EXISTS THNews
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE THNews;

-- 2️⃣ Bảng USER
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(150) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    user_role BOOLEAN DEFAULT FALSE,  -- TRUE = admin, FALSE = user,
    user_address VARCHAR(500),
    user_image_path VARCHAR(255),
    user_bio TEXT,
    user_status BOOLEAN DEFAULT FALSE, 
    user_forget_token VARCHAR(500), 
    user_active_token VARCHAR(500),  
    user_created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO user (user_email, user_password, user_name, user_role, user_address, user_image_path, user_bio, user_status) 
VALUES 
("nva@gmail.com", md5("nva123"), "Nguyễn Văn A", FALSE, "899/45, đường vào tim e, phường Bình Đức, tỉnh An Giang", 'templates/uploads/hehe.jpg', "I'm Van A, 20 years old, love green color", TRUE),
("admin@gmail.com", md5("admin123"), "Administrator", TRUE, "123, Ung Van Khiem Street, Long Xuyen Ward, An Giang Province", 'templates/uploads/hoa.png', "I'm admin of this website, 12 years old,....", TRUE);


-- 3️⃣ Bảng CATEGORY
CREATE TABLE category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    category_created_at DATETIME DEFAULT CURRENT_TIMESTAMP
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
('Bão có thể mạnh cấp 14 khi vào vùng biển Đà Nẵng - Khánh Hòa',
 'Không khí lạnh suy yếu trong khi độ ẩm, nhiệt độ bề mặt biển, độ đứt gió đang thuận lợi khiến bão Kalmaegi có thể đạt cấp 14 khi vào vùng biển Đà Nẵng - Khánh Hòa.',
 'Lúc 16h hôm nay, bão Kalmaegi trên vùng biển phía tây miền Trung Philippines, cách đảo Song Tử Tây khoảng 770 km về phía đông, sức gió mạnh nhất gần tâm bão 149 km/h, cấp 13, giật cấp 16 và theo hướng tây với tốc độ khoảng 25 km/h.
    <br> <br>
  Tại cuộc họp thông tin diễn biến bão Kalmaegi chiều nay, ông Mai Văn Khiêm, Giám đốc Trung tâm Dự báo Khí tượng Thủy văn quốc gia, cho biết rạng sáng mai bão sẽ vượt qua phía bắc của đảo Palawan, Philippines vào Biển Đông.
    <br> <br>
  Bão sẽ đạt cực đại cấp 14 (166 km/h), giật cấp 16-17 vào ngày 6/11, thậm chí có mô hình cho rằng bão sẽ trên cấp 14 khi ở đặc khu Trường Sa và trên vùng biển Đà Nẵng - Khánh Hòa. Chiều cùng ngày, bão sẽ vào vùng biển miền Trung.
    <br> <br>
  "Các yếu tố khí quyển, nhiệt lực làm cơn bão suy yếu rất ít. Hiện không khí lạnh đã suy yếu, nhiệt độ bề mặt Biển Đông đang tương đối cao, độ ẩm trong khí quyển lớn. Độ đứt gió ở mức trung bình khá thuận lợi cho bão phát triển cùng với đó bão hoạt động trên dải hội tụ nhiệt đới", ông Khiêm nói.
     <br> <br>
  Từ chiều tối 6/11, trên đất liền ven biển nam Quảng Trị - Đà Nẵng, phía đông Quảng Ngãi và Đăk Lăk gió mạnh dần từ cấp 6 đến 12, giật cấp 14-15. Phía tây Quảng Ngãi và Gia Lai gió cấp 8, giật cấp 10. Trọng tâm gió rất mạnh là phía đông Quảng Ngãi, Đăk Lăk.
    <br> <br>
  "Kalmaegi là cơn bão rất mạnh, hoàn lưu rộng. Đường đi và tác động tương tự với bão Damrey năm 2017 và Molave 2020, đều là cơn bão mạnh, gây nhiều thiệt hại", ông Khiêm nói và đặc biệt lưu ý đặc khu Lý Sơn sẽ có gió rất lớn, nếu tương tự Molave thì người dân sẽ phải xuống hầm trú ẩn.
     <br> <br>
  Ông Mai Văn Khiêm cho biết do các yếu tố như không khí lạnh, gió đông suy yếu nên đợt mưa sắp tới chủ yếu do hoàn lưu của bão. Do đó, hướng đi của bão sẽ quyết định khu vực mưa lớn. Hiện cơ quan khí tượng nhận định ngày 6-7/11, các tỉnh thành Đà Nẵng - Đăk Lăk mưa 200-400 mm, cục bộ trên 600 mm. Nam Quảng Trị - Huế, Khánh Hòa, Lâm Đồng mưa 150-300 mm, cục bộ trên 450 mm.
    <br> <br>
  Ngày 7-8/11, Thanh Hóa, Nghệ An mưa 50-150 mm, cục bộ có nơi trên 200 mm. Cảnh báo nguy cơ mưa có cường độ lớn trên 200 mm trong ba giờ.
    <br> <br>
  So với đợt mưa lũ cuối tháng 10 đầu tháng 11, đợt lũ sắp tới ở Huế - Đà Nẵng có thể không bằng. Tại Quảng Trị, lũ sông Gianh, Thạch Hãn trên báo động một, Kiến Giang trên báo động hai. Tại Huế, lũ sông Bồ, Hương lên báo động ba, trên báo động ba. Tại Đà Nẵng, lũ sông Vu Gia - Thu Bồn lên báo động ba, trên báo động ba.
    <br> <br>
  Lũ sông Trà Khúc, Vệ ở Quảng Ngãi lên báo động ba, trên báo động ba; sông An Lao, Lại Giang, Sê San tại Gia Lai trên báo động hai; sông Ba tại Đăk Lăk lên báo động hai, ba; sông Kỳ Lộ trên báo động ba; sông Dinh Ninh Hòa tại Khánh Hòa trên báo động hai.',
 'templates/uploads/bao-1762255887-2152-1762255955.webp',
 'Hệ thống giám sát thiên tai Việt Nam',
 TRUE, 1, 1),

 ('Sạt lở núi đè ôtô khách ở Khánh Hòa, 6 người chết',
  'Mưa lớn khiến đèo Khánh Lê ở quốc lộ 27C sạt lở, đất đá vùi lấp xe khách từ Đà Lạt xuống Nha Trang, 6 người tử vong, 19 người bị thương, cứu hộ đang tìm nạn nhân, sáng 17/11.',
  'Gần 22h hôm qua, xe khách Phương Trang 34 chỗ biển số TP HCM chở 32 người, trong đó có hai tài xế, một phụ xe, chạy trên đèo Khánh Lê hướng Đà Lạt – Nha Trang để ra Quảng Ngãi. Đến khu vực Nam Khánh Vĩnh, đèo sạt lở, đất đá đổ xuống vùi lấp một phần xe.
    <br> <br>
  Cabin bị đất đá tách rời, thân bên phải ôtô biến dạng, vỡ kính, khung sắt và giường nằm méo mó. Nhiều người mắc kẹt bên trong. Đất đá cũng vùi nhiều xe máy gần đó.
    <br> <br>
  Mưa lớn khiến hai đầu đèo sạt lở trên đoạn dài gần 4 km. Lực lượng cứu hộ mất hơn hai giờ mở đường tiếp cận hiện trường. Cảnh sát PCCC huy động hai xe chuyên dụng, gần 20 cán bộ chiến sĩ đào bới đưa nạn nhân ra ngoài.
    <br> <br>
  Tai nạn làm 6 người chết (3 nam, 3 nữ). Bốn thi thể đã được đưa ra, hai người còn kẹt dưới các khối đá lớn. Có 19 người bị thương. Giám đốc Bệnh viện Đa khoa Khánh Hòa Lê Vũ Chương cho biết ba ca nặng đã được phẫu thuật; 16 người còn lại bị chấn thương ở đầu, chân tay, không nguy hiểm đến tính mạng.
    <br> <br>
  Theo Công an Khánh Hòa, xe gặp nạn khi chạy gần taluy dương. Đất đá từ núi đã đè bẹp khoảng nửa thân xe. Mưa lớn và nguy cơ tiếp tục sạt lở gây khó khăn cho cứu hộ.
    <br> <br>
  Đại diện Công ty Phương Trang cho biết hệ thống định vị ghi nhận tai nạn lúc 21h39 ngày 16/11. Xe khách bị nạn loại 34 phòng riêng (xe limousine), chạy tuyến Đà Lạt – Quảng Ngãi. Hai tài xế và phụ xe đều bị thương, trong đó một người chấn thương nặng. Số khách an toàn đã được đưa về bến của nhà xe ở Nha Trang.
    <br> <br>
  Quốc lộ 27C dài 121 km nối Đà Lạt – Nha Trang, là tuyến chính của xe du lịch. Đèo Khánh Lê dài 33 km, thường sạt lở mùa mưa.
    <br> <br>
  Thời gian qua, mưa lớn kéo dài ở các tỉnh miền Trung, gây ra một số vụ sạt lở. Gần đây nhất, tối qua đèo Khánh Sơn đoạn qua xã Cam An (Khánh Hoà) sạt lở, vùi lấp lán trại cùng ba người bên trong. Sự cố khiến một người chết, một bị thương, một nạn nhân mất tích. Thời điểm núi sạt, trong lán có 10 người.
    <br> <br>
  Cách đây ba ngày, vạt núi tại thôn Pứt, xã Hùng Sơn (Đà Nẵng) bị sạt, đất đá chảy xuống suối, vùi nhiều chòi canh rẫy, ba người mất tích hiện chưa tìm thấy.',
  'templates/uploads/783699063009970484-1763345151-7983-1787-1763345279.webp',
  'Xe khách bị đá rơi biến dạng phần đầu. Ảnh: Minh Bằng',
  TRUE, 2, 1),

('Lũ tràn về đô thị Huế',
  'Mưa lớn, thủy điện ở thượng nguồn sông Hương, sông Bồ xả lũ về hạ du khiến nhiều tuyến đường, khu dân cư ở đô thị Huế lại bị ngập.',
  'Sáng 17/11, nước lũ tràn qua Đập Đá nằm giữa sông Hương và sông Như Ý. Tuyến đường đi bộ ven sông Như Ý ngập hơn 0,5 m, nước tràn vào nhiều nhà dân ven sông. Nằm ở hạ lưu sông Như Ý, các tuyến đường Tố Hữu, Vũ Thắng, Phan Anh bị ngập, giao thông khó khăn.
    <br> <br>
  Cư dân ở các tòa chung cư Aranya, Xuân Phú, Vicoland, phường Vỹ Dạ vội vã đưa ôtô ra đậu kín công viên Hành chính công tránh lũ. Anh Nguyễn Văn Nhân, 45 tuổi, ở phường An Cựu, cho biết sáng mở cửa đã thấy nước ngập đường nên vội lái xe đi tránh.
    <br> <br>
  "Đỗ xe lên đây cho an toàn. Đợt lũ trước, lái xe ra đỗ sớm nên thoát được cảnh bị ngâm nước như nhiều ôtô khác", anh Nhân nói.
    <br> <br>
  Nằm ở hạ lưu sông Bồ, nhiều tuyến đường liên thôn, liên xóm tại các xã Quảng Điền, Đan Điền, phường Hóa Châu bị ngập khi thủy điện Hương Điền xả lũ khoảng 3.000 m3/s. Nước lũ tràn về nhanh gây ngập quốc lộ 1 đoạn qua phường Hương Trà. Cảnh sát giao thông phải túc trực để điều tiết giao thông.
    <br> <br>
  Ông Nguyễn Ánh Cầu, Chủ tịch xã Quảng Điền, cho biết từ đêm qua nước lũ tràn về đã chia cắt các tuyến đường về xã Quảng Thọ, Quảng An, tràn vào hàng trăm nhà dân ven sông Bồ với độ sâu 0,5 m. Hiện nay, các tuyến đường đã được rào chắn và bố trí lực lượng túc trực. Sáng nay, một người dân cố tình vượt rào bị lũ cuốn, may mắn cứu kịp thời.
    <br> <br>
  Chi cục Thủy lợi và Biến đổi khi hậu TP Huế cho biết mực nước sông Hương tại trạm Kim Long là lúc 9h sáng nay là 2,76 trên báo động hai 0,76 m; sông Bồ tại trạm Phú Ốc 4,93 m, trên báo động ba là 0,43 m.
    <br> <br>
  Dự báo, mưa cường suất lớn trong ngày 17-18/11 sẽ gây ngập 0,3-0,5 m một số khu vực quốc lộ 1 đoạn qua xã Phú Lộc với mức ngập 0,3-0,5 m, khu đô thị An Cựu, Thuận Hóa, đường Ngô Đức Kế, Thánh Gióng, Phú Xuân.
    <br> <br>
  Đài Khí tượng Thủy văn TP Huế dự báo từ sáng nay đến sáng 19/11, Huế mưa rất to. Tổng lượng mưa ở vùng đồng bằng phổ biến 150-300 mm, có nơi trên 400 mm; vùng núi 200-400 mm, có nơi trên 500 mm.',
  'templates/uploads/2-1763347148-1763347200-6108-1763347252.webp',
  'Các tuyến đường ở khu đô thị mới An Vân Dương bị nước lũ tràn vào gây ngập. Ảnh: Võ Thạnh',
  TRUE, 2, 1),

-- 2. World
('Global Leaders Meet for Climate Summit',
 'World leaders gathered in Paris to discuss urgent measures to address the escalating climate crisis.',
 'The 2025 Global Climate Summit opened today in Paris, drawing leaders from over 70 countries to discuss the growing impacts of global warming.
    <br> <br>
  In his opening remarks, the UN Secretary-General emphasized the importance of collective action and urged nations to commit to stricter emission targets. Several countries announced new pledges to phase out fossil fuels by 2040.
    <br> <br>
  Environmental activists rallied outside the venue, demanding greater accountability from major polluters. The summit is expected to last for three days, with discussions focused on renewable energy, deforestation, and ocean protection.',
 'templates/uploads/leaders_meet-a0a0a32375cf7d12b2c2db3ef642f2cd.jpg',
 'Leaders attending the Climate Summit 2025 in Paris',
 TRUE, 1, 2),

-- 3. Business
('Tech Stocks Rally as Markets Recover',
 'The global stock market rebounded as investors regained confidence in major technology firms.',
 'After weeks of volatility, global stock markets rallied today, driven largely by strong earnings reports from leading tech companies like Meta, Google, and Microsoft.
    <br> <br>
  Analysts credit the recovery to renewed investor optimism and better-than-expected performance across the AI and semiconductor sectors. The NASDAQ rose 2.3%, marking its strongest daily gain this quarter.
    <br> <br>
  Despite the positive momentum, experts caution that uncertainty remains due to inflation concerns and shifting global trade policies. Investors are advised to remain selective in the coming weeks as market trends stabilize.',
 'templates/uploads/38d4d70886c8a2dd73f3e5f1497c8f73.jpg',
 'Stock market chart showing an upward trend',
 TRUE, 2, 3),

 ('Ông Trump ký sắc lệnh miễn thuế cho hàng loạt nông sản',
  'Nhiều loại thực phẩm thiết yếu như thịt bò, cà chua, chuối sẽ được miễn thuế đối ứng khi nhập khẩu vào Mỹ.',
  'Ngày 14/11, Tổng thống Mỹ Donald Trump ký sắc lệnh miễn thuế đối ứng với hàng loạt thực phẩm. Đó là cà phê, trà, trái cây nhiệt đới và nước ép trái cây, hạt cacao, gia vị, chuối, cam, cà chua, thịt bò và một số loại phân bón.
    <br> <br>
  Nhiều sản phẩm trong danh sách miễn thuế đã ghi nhận mức tăng giá hai chữ số trong năm nay. Ví dụ, theo Chỉ số Giá Tiêu dùng (CPI) tháng 9, thịt bò xay đã tăng gần 14%, còn bò miếng tăng 17% so với năm ngoái. Đây là mức tăng mạnh nhất hơn 3 năm.
    <br> <br>
  Giá chuối tăng 7%, cà chua tăng 1%. Tổng cộng nhóm thực phẩm tiêu thụ tại gia đình tăng giá 2,7% trong tháng 9 so với năm ngoái.
    <br> <br>
  Sắc lệnh ngày 14/11 điều chỉnh phạm vi áp thuế đối ứng mà ông Trump công bố hôm 2/4, loại ra nhiều nông sản không thể sản xuất tại Mỹ. Ngày 5/9, Tổng thống Mỹ từng ký sắc lệnh điều chỉnh tương tự, miễn thuế đối ứng cho 45 nhóm hàng hóa như vàng, nickel, hóa chất,... Đây là các sản phẩm "không thể được trồng, khai thác và sản xuất tự nhiên ở Mỹ", hoặc không sản xuất đủ để đáp ứng nhu cầu trong nước.
    <br> <br>
  Sắc lệnh miễn trừ mới nhất có hiệu lực từ ngày 13/11, đánh dấu bước ngoặt trong chính sách của ông Trump. Tổng thống Mỹ từ lâu vẫn khẳng định việc tăng mạnh thuế nhập khẩu không thổi bùng lạm phát.
    <br> <br>
  Việc này được công bố chỉ một ngày sau khi Mỹ đạt khung thỏa thuận thương mại với Argentina, Ecuador, Guatemala và El Salvador. Chính quyền Trump hôm 14/11 cũng đã đạt thỏa thuận với Thụy Sĩ. Các quan chức Mỹ dự kiến đạt thêm nhiều thỏa thuận khác trong năm nay. Việc này sẽ mở đường cho giảm thuế với hàng loạt sản phẩm khác.
    <br> <br>
  Vài tuần gần đây, ông Trump đề cập nhiều đến vấn đề chi phí sinh hoạt. Ông khẳng định giá cả tăng cao là do các chính sách của người tiền nhiệm, chứ không phải do thuế nhập khẩu.
    <br> <br>
  Các nhà kinh tế học thì cho rằng chi phí tăng cao một phần do thuế nhập khẩu. Giá cả sinh hoạt có thể tiếp tục tăng trong năm tới, khi các doanh nghiệp bắt đầu chuyển gánh nặng xuống người mua.',
  'templates/uploads/beef-1763169573-1763169598-9197-1763169733.webp',
  'Thịt bò bán trong một gian hàng ở Washington (Mỹ). Ảnh: Reuters',
  TRUE, 1, 3),

-- 4. Sports
('Mbappe - Guler: Cặp bài trùng gợi nhớ về Ronaldo - Ozil',
 'Không cầu thủ nào kiến tạo cho Kylian Mbappe ghi bàn nhiều ở mùa này như Arda Guler mùa này, tương tự cách Mesut Ozil từng ăn ý với Cristiano Ronaldo thời cả hai còn sát cánh ở Real Madrid.',
 'Khi ghi cú đúp trong trận Real hạ Valencia 4-0 cuối tuần qua, Mbappe không chỉ nâng thành tích ghi bàn mùa này của anh trên mọi đấu trường mùa này lên con số 18, mà còn kéo theo sự gia tăng một chỉ số khác của đồng đội. 
    <br> <br>
  Trong 18 bàn đó của tiền đạo người Pháp, có 6 bàn từ phạt đền và một bàn không tính kiến tạo. Với 11 bàn còn lại, Guler kiến tạo cho Mbappe 6 bàn, nhiều hơn bất kỳ ai, và lần gần nhất là ở pha lập công thứ hai của Mbappe trước Valencia.',
 'templates/uploads/guler-1-1762223703-1762225233-7724-1762225241.webp',
 'Team lifting the championship trophy',
 TRUE, 2, 4),

-- 5. Technology
('Robot hình người Trung Quốc "gây họa" trong bếp',
 'Robot G1 nổi tiếng của công ty Unitree lúng túng cầm chảo, làm đổ thức ăn ra sàn bếp và trượt ngã.',
 'Bên dưới, tài khoản bishara tiếp tục chia sẻ clip khác cho thấy G1 xông vào phòng một cách mạnh mẽ, làm vỡ cửa kính. Nhưng sau đó, có vẻ robot không kiểm soát được tốc độ, đâm sầm vào giá đỡ camera và tường. Những clip này đều trích từ video "Điều gì xảy ra nếu bạn ngược đãi robot?" của YouTuber Cody Detwiler.
    <br> <br>
  Một sự cố tương tự xảy ra hồi tháng 3, người dùng Zhang Genyuan giao cho G1 nhiệm vụ nấu ăn. Robot vật lộn với những việc đơn giản như đập trứng và rót sữa. Nỗ lực dọn nhà của nó cũng không suôn sẻ khi thường xuyên dẫn đến va chạm, đổ vỡ.
    <br> <br>
  G1 chủ yếu được thiết kế cho mục đích công nghiệp và nghiên cứu, nhưng Unitree Robotics đã đa dạng hóa khả năng của nó, mở rộng sang làm việc nhà. Trường hợp của Cody Detwiler và Zhang Genyuan cho thấy G1 chưa sẵn sàng cho nhiệm vụ đòi hỏi độ chính xác cao. Robot hình người đang có những bước tiến ấn tượng, nhưng vẫn chưa thực sự phối hợp ăn ý với con người.',
 'templates/uploads/unitreeg1cooking-1762232515-17-3227-1244-1762232680.webp',
 'Robot hình người G1 làm rơi chảo thức ăn trong bếp. Ảnh: X/bishara.',
 TRUE, 2, 5),

-- 6. Health
('Tiêm vaccine phòng bệnh cho cả lớp học',
 'Cô Hồ Thị Lực, 42 tuổi, ở Hà Nội, đăng ký tiêm cúm theo chương trình của nhà trường, để chống ốm đầu năm học.',
 'Cô Lực là giáo viên mẫu giáo, cho biết trẻ mầm non còn nhỏ, ý thức giữ gìn vệ sinh chưa cao, sinh hoạt cùng nhiều bé khác. Do vậy, hễ một bé ho, sốt, sổ mũi là các bé khác cũng lần lượt lây và ngã bệnh. Hơn nữa, giáo viên cũng có thể mắc bệnh lây cho trẻ và ngược lại, gián đoạn việc dạy.
    <br> <br>
  Vì vậy, cô coi việc phòng bệnh trong lớp học là ưu tiên hàng đầu, bắt đầu bằng việc chủ động phòng bệnh cho bản thân. Nếu phụ huynh còn ngần ngại chưa cho con tiêm vaccine, cô cũng tìm hiểu và động viên gia đình phòng bệnh cho con. Bên cạnh vaccine, cô Lực cũng luôn đặt ra quy định nghiêm ngặt khi vệ sinh trường lớp, dụng cụ học tập, đồ chơi, ăn uống đảm bảo an toàn, sạch sẽ nhằm bảo vệ sức khỏe cho các bé.',
 'templates/uploads/233a3450-1757134057-1762247285-5828-7583-1762247871.webp',
 'Cô giáo và học sinh đều cần có sức khỏe tốt để đảm bảo việc học tập không bị gián đoạn. Ảnh minh họa: Quỳnh Trần.',
 TRUE, 2, 6),

-- 7. Science
('Tàu Trung Quốc chở phi hành gia trẻ nhất lên trạm Thiên Cung',
 'Tàu Thần Châu 21 phóng từ sa mạc Gobi đang bay tới trạm Thiên Cung trên quỹ đạo Trái Đất, chở phi hành gia trẻ nhất của Trung Quốc và chuột thí nghiệm.',
 'Theo Space, tên lửa Trường Chinh 2F đưa tàu vũ trụ Thần Châu 21 cất cánh từ Trung tâm phóng vệ tinh Tửu Tuyền ở đông bắc Trung Quốc vào 23h44 ngày 31/10 giờ địa phương (22h44 cùng ngày giờ Hà Nội). Dự kiến tàu vũ trụ sẽ ghép nối với cổng trước của module lõi Thiên Hòa thuộc trạm vũ trụ Thiên Cung khoảng 3,5 giờ sau khi cất cánh, sử dụng chế độ gặp nhanh tự động giúp tiết kiệm 3 giờ so với nhiệm vụ Thần Châu 20.
    <br> <br>
  Tàu Thần Châu 21 chở chỉ huy Zhang Lu (48 tuổi) từng tham gia nhiệm vụ Thần Châu 15 năm 2022 cùng hai phi hành gia mới là Wu Fei và Zhang Hongzhang được chọn từ lứa phi hành gia thứ 3 của Trung Quốc tuyển năm 2020. Ở tuổi 32, Wu là thành viên trẻ nhất trong đội phi hành gia Trung Quốc, làm kỹ sư ở Học viện Công nghệ vũ trụ (CAST). Zhang (39 tuổi), chuyên gia hàng hóa trên tàu, là nhà nghiên cứu ở Viện Vật lý hóa học Đại Liên thuộc Viện hàn lâm Khoa học Trung Quốc (CAS). Zhang Lu và đồng nghiệp sẽ gặp gỡ chỉ huy Chen Dong của nhiệm vụ Thần Châu 20 và hai thành viên khác là Chen Zhongrui và Wang Jie trên trạm Thiên Cung. Chen Dong gần đây trở thành phi hành gia Trung Quốc đầu tiên trải qua 400 ngày trên quỹ đạo, nhưng ông và đồng nghiệp sẽ sớm rời khỏi trạm Thiên Cung để trở về Trái Đất vào ngày 3/11.',
 'templates/uploads/VNE-As-1761929803-9604-1761929877.webp',
 'Tên lửa Trường Chinh 2F chở tàu Thần Châu 21 cất cánh hôm 31/10. Ảnh: CCTV.',
 TRUE, 1, 7),

-- 8. Entertainment
('Gen Alpha và áp lực "học cắm đầu cắm cổ"',
 'Jennifer B. Wallace gọi trẻ em là thế hệ "học cắm đầu cắm cổ", chịu nhiều kỳ vọng của người lớn, trong "Gen Alpha và áp lực thành tích".',
 'Học hành, thể thao và các hoạt động ngoại khóa ngày càng trở nên cạnh tranh, được người lớn dẫn dắt và mang tính đánh cược cao. Wallace chỉ ra "những đứa trẻ này đang chạy theo một lộ trình đã được vạch sẵn mà không đủ thời gian nghỉ ngơi hay cơ hội để quyết định liệu đó có phải là cuộc đua mà chúng muốn tham gia hay không". Kết quả, trẻ em tiếp nhận tư tưởng rằng giá trị của chúng phụ thuộc vào thành tích, điểm số GPA, số lượng người theo dõi trên mạng xã hội, thương hiệu trường đại học chứ không phải con người thật.
    <br> <br>
  Ngoài ra, lớn lên trong một cộng đồng nhiều người thành công về mặt vật chất có thể làm tăng áp lực lên trẻ, khiến chúng cảm thấy cần phải có trách nhiệm duy trì vị thế của gia đình.
    <br> <br>
  Sự căng thẳng trong học tập, cạnh tranh không lành mạnh dễ khiến trẻ mắc chứng rối loạn lo âu và trầm cảm. Sách đưa số liệu từ các cuộc khảo sát quốc gia tại Mỹ về thanh thiếu niên, cho thấy sự gia tăng về tỷ lệ mắc một số vấn đề sức khỏe tinh thần. Năm 2019, một phần ba số học sinh trung học và một nửa số nữ sinh được ghi nhận có cảm xúc buồn bã hoặc tuyệt vọng kéo dài. Tác phẩm nêu: "Một học sinh ở New York nhớ lại đã bật khóc trong lớp 3 vì cô bé nghĩ rằng việc nhận điểm C trong bài kiểm tra toán làm hỏng cơ hội vào Harvard và sống một cuộc sống tốt đẹp".',
 'templates/uploads/gen-alpha-va-ap-luc-thanh-tich-1792-5276-1761878463.webp',
 'Bìa "Gen Alpha và áp lực thành tích", sách do Lê Thanh Sơn dịch, 1980 Books và NXB Công Thương liên kết ấn hành. Ảnh: 1980 Books.',
 TRUE, 1, 8);
