<?php layoutUser('header'); ?>

<main class="container py-5">

    <!-- Header Banner -->
    <section class="text-center text-light p-5 rounded mb-5" 
        style="background: linear-gradient(135deg, #007bff, #6610f2);">
        <h1 class="fw-bold mb-3">Về Chúng Tôi</h1>
        <p class="fs-5">Nơi tin tức được cập nhật chính xác và khách quan mỗi ngày</p>
    </section>

    <!-- Intro -->
    <section class="mb-5">
        <h3 class="fw-bold mb-3 text-primary">Chúng Tôi Là Ai?</h3>
        <p>
            <strong>TH News</strong> ra đời với sứ mệnh tạo ra một không gian thông tin 
            đáng tin cậy trong thời đại số hóa. Chúng tôi giúp độc giả nắm bắt bức tranh toàn cảnh 
            về các sự kiện diễn ra trong nước và quốc tế.
        </p>
        <p>
            <strong>TH = Tin tức Tổng Hợp</strong> — chúng tôi cung cấp nội dung đa dạng, chuyên sâu và thiết thực.
        </p>
    </section>

    <!-- Mission - Vision -->
    <section class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="p-4 border rounded shadow-sm h-100 card-about">
                <h4 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-bullseye me-2"></i>Sứ Mệnh
                </h4>
                <p>
                    Mang đến thông tin <strong>Nhanh chóng – Chính xác – Khách quan – Hữu ích</strong> 
                    phục vụ cộng đồng và xã hội.
                </p>
            </div>
        </div>
        <div class="col-md-6 mb-4 ">
            <div class="p-4 border rounded shadow-sm h-100 card-about">
                <h4 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-bar-chart-line me-2"></i>Tầm Nhìn
                </h4>
                <p>
                    Trở thành nền tảng thông tin uy tín hàng đầu, đồng hành cùng mỗi độc giả trong thời đại số.
                </p>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="mb-5">
        <h4 class="fw-semibold mb-3 text-primary"><i class="bi bi-gem me-2"></i>Giá Trị Cốt Lõi</h4>
        <ul class="values-list">
            <li><strong>Chính trực</strong> — đặt sự thật lên hàng đầu.</li>
            <li><strong>Khách quan</strong> — phản ánh đa chiều, không thiên vị.</li>
            <li><strong>Trách nhiệm</strong> — đóng góp tích cực cho cộng đồng.</li>
            <li><strong>Tôn trọng</strong> — tuân thủ đạo đức báo chí và tôn trọng độc giả.</li>
        </ul>
    </section>

    <!-- Content Types -->
    <section class="mb-5">
        <h4 class="fw-semibold mb-3 text-primary">
        <i class="bi bi-newspaper me-2"></i>Chúng Tôi Mang Đến
        </h4>

        <div class="row g-3">
            <?php
            $features = [
                ['Tin tức nóng', 'bi-lightning'],
                ['Phân tích - Bình luận', 'bi-chat-dots'],
                ['Kinh tế - Tài chính', 'bi-cash-coin'],
                ['Công nghệ', 'bi-cpu'],
                ['Văn hóa - Giải trí', 'bi-camera-reels'],
                ['Thể thao', 'bi-trophy']
            ];
            foreach ($features as $item) {
                echo '
                <div class="col-md-4">
                    <div class="d-flex align-items-center p-3 border rounded shadow-sm bg-white h-100 card-about">
                        <i class="bi '.$item[1].' fs-4 text-primary me-3"></i>
                        <span>'.$item[0].'</span>
                    </div>
                </div>';
            }
            ?>
        </div>
    </section>

    <!-- Contact -->
    <section class="mb-5">
        <h4 class="fw-semibold mb-3 text-primary"><i class="bi bi-link-45deg me-2"></i>Kết Nối</h4>
        <p class="mb-3">Hãy góp ý để chúng tôi phục vụ tốt hơn!</p>
        <ul class="list-unstyled">
            <li><i class="bi bi-envelope-at me-2 text-primary"></i>Email: <a href="#">thnewswebsite@gmail.com</a></li>
            <li><i class="bi bi-telephone me-2 text-primary"></i>Hotline: (+84) 123 456 789</li>
            <li><i class="bi bi-geo-alt me-2 text-primary"></i>Địa chỉ: Số 18, đường Ung Văn Khiêm, phường Long Xuyên, tỉnh An Giang.</li>
        </ul>
    </section>

    <div class="text-center mt-5">
        <p class="fw-bold text-primary">Cảm ơn bạn đã đồng hành cùng TH News!</p>
    </div>

</main>


<?php layoutUser('footer'); ?>
