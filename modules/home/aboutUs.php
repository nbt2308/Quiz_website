<?php layoutUser('header'); ?>

<main class="container py-5">

    <!-- Header Banner -->
    <section class="text-center text-light p-5 rounded mb-5" 
        style="background: linear-gradient(135deg, #007bff, #6610f2);">
        <h1 class="fw-bold mb-3">About Us</h1>
        <p class="fs-5">Where news is updated accurately and objectively every day</p>
        <!-- (Nơi tin tức được cập nhật chính xác và khách quan mỗi ngày) -->
    </section>

    <!-- Intro -->
    <section class="mb-5">
        <h3 class="fw-bold mb-3 text-primary">Who Are We?</h3>
        <!-- (Chúng Tôi Là Ai?) -->
        <p>
            <strong>TH News</strong> was created with the mission to build a reliable 
            information space in the digital era. We help readers capture the big picture 
            of events happening both domestically and internationally.
            <!-- (TH News ra đời với sứ mệnh tạo ra một không gian thông tin đáng tin cậy 
                 trong thời đại số hóa...) -->
        </p>
        <p>
            <strong>TH = Tổng Hợp (General News)</strong> — we provide diverse, 
            in-depth, and practical content.
            <!-- (TH = Tin tức Tổng Hợp — chúng tôi cung cấp nội dung đa dạng, chuyên sâu và thiết thực.) -->
        </p>
    </section>

    <!-- Mission - Vision -->
    <section class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="p-4 border rounded shadow-sm h-100 card-about">
                <h4 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-bullseye me-2"></i>Our Mission
                </h4>
                <p>
                    Delivering information that is <strong>Fast – Accurate – Objective – Useful</strong> 
                    to serve the community and society.
                    <!-- (Mang đến thông tin Nhanh chóng – Chính xác – Khách quan – Hữu ích phục vụ cộng đồng và xã hội.) -->
                </p>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="p-4 border rounded shadow-sm h-100 card-about">
                <h4 class="fw-semibold text-primary mb-3">
                    <i class="bi bi-bar-chart-line me-2"></i>Our Vision
                </h4>
                <p>
                    To become a leading and trusted information platform, accompanying every reader 
                    in the digital age.
                    <!-- (Trở thành nền tảng thông tin uy tín hàng đầu, đồng hành cùng mỗi độc giả trong thời đại số.) -->
                </p>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="mb-5">
        <h4 class="fw-semibold mb-3 text-primary"><i class="bi bi-gem me-2"></i>Core Values</h4>
        <ul class="values-list">
            <li><strong>Integrity</strong> — putting truth above all.</li>
            <li><strong>Objectivity</strong> — reflecting multiple perspectives without bias.</li>
            <li><strong>Responsibility</strong> — contributing positively to the community.</li>
            <li><strong>Respect</strong> — following journalism ethics and respecting readers.</li>
        </ul>
    </section>

    <!-- Content Types -->
    <section class="mb-5">
        <h4 class="fw-semibold mb-3 text-primary">
        <i class="bi bi-newspaper me-2"></i>What We Deliver
        </h4>

        <div class="row g-3">
            <?php
            $features = [
                ['Breaking News', 'bi-lightning'],
                ['Analysis & Commentary', 'bi-chat-dots'],
                ['Economy & Finance', 'bi-cash-coin'],
                ['Technology', 'bi-cpu'],
                ['Culture & Entertainment', 'bi-camera-reels'],
                ['Sports', 'bi-trophy']
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
        <h4 class="fw-semibold mb-3 text-primary"><i class="bi bi-link-45deg me-2"></i>Contact Us</h4>
        <p class="mb-3">We’d love your feedback to serve you better!</p>
        <ul class="list-unstyled">
            <li><i class="bi bi-envelope-at me-2 text-primary"></i>Email: <a href="#">thnewswebsite@gmail.com</a></li>
            <li><i class="bi bi-telephone me-2 text-primary"></i>Hotline: (+84) 123 456 789</li>
            <li><i class="bi bi-geo-alt me-2 text-primary"></i>Address: No.18, Ung Van Khiem Street, Long Xuyen Ward, An Giang Province.</li>
        </ul>
    </section>

    <div class="text-center mt-5">
        <p class="fw-bold text-primary">Thank you for accompanying TH News!</p>
        <!-- (Cảm ơn bạn đã đồng hành cùng TH News!) -->
    </div>

</main>

<?php layoutUser('footer'); ?>