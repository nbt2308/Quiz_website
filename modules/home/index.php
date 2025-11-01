<?php
// if(!defined('_USER')){
//     die("Truy cập không hợp lệ") ;
// }


//lấy tất cả tên chủ đề






//home
include_once 'templates\layout\user\header.php';
?>
<main>
    <div class="category container">
        <?php
        $sql = "SELECT category_name FROM category";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="category-title">
                        <a href="#"><strong>' . htmlspecialchars($row['category_name']) . '</strong></a>
                    </div>
        ';
            }
        } else {
            echo "<p>Không có dữ liệu.</p>";
        }
        ?>
        <!-- <div class="category-title"><a href="#"><strong>Breaking news</strong></a></div>
        <div class="category-title"><a href="#"><strong>World</strong></a></div>
        <div class="category-title"><a href="#"><strong>Business</strong></a></div>
        <div class="category-title"><a href="#"><strong>Sports</strong></a></div>
        <div class="category-title"><a href="#"><strong>Technology</strong></a></div>
        <div class="category-title"><a href="#"><strong>Health</strong></a></div>
        <div class="category-title"><a href="#"><strong>Entertainment</strong></a></div>
        <div class="category-title"><a href="#"><strong>Law</strong></a></div>
        <div class="category-title"><a href="#"><strong>Education</strong></a></div>
        <div class="category-title"><a href="#"><strong>Lifestyle</strong></a></div> -->
    </div>
    <div class="main container mt-3">
        <div class="left-container ">


            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                    $sql2 = "SELECT n.*, c.category_name
                            FROM news n
                            JOIN category c ON n.category_id = c.category_id
                            JOIN (
                                SELECT category_id, MAX(news_post_date) AS latest_post
                                FROM news
                                GROUP BY category_id
                            ) vmax ON n.category_id = vmax.category_id AND n.news_post_date = vmax.latest_post;";

                    $result = $conn->query($sql2);
                    if ($result->num_rows > 0) {
                        $isActive = true;
                        while ($row = $result->fetch_assoc()) {
                            echo '
                    <div class="carousel-item ' . ($isActive ? 'active' : '') . '">
                        <div class="d-flex align-items-center justify-content-center p-3">
                            <img src="' . $row['news_image_path'] . '" alt="News image" class="rounded me-3" alt="ảnh 1" style="width:400px;height:250px;object-fit:cover;">
                            <div>
                                <a class="fw-bold text-decoration-none" href="#" >' . htmlspecialchars($row['news_title']) . ' </a>
                                <div class="text-limit">
                                    <p class="text-muted mb-0">'
                                . htmlspecialchars($row['news_description']) .
                                '</p>
                                </div>
                                <p class="mt-5">Ngày đăng: ' . htmlspecialchars($row['news_post_date']) . '</p>
                            </div>
                        </div>
                    </div>
        ';
                            $isActive = false;
                        }
                    } else {
                        echo "<p>Không có dữ liệu.</p>";
                    }
                    ?>



                </div>

                <!-- Nút điều hướng -->
                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>

                <!-- Chấm nhỏ bên dưới -->
                <div class="carousel-indicators mt-3">
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="2"></button>
                </div>
            </div>
            <div class="news-card my-3">
                <?php
                $category_id = 1; // ví dụ id chuyên mục
                $sql3 = "SELECT n.*, c.category_name
                        FROM news n
                        INNER JOIN category c ON n.category_id = c.category_id
                        INNER JOIN (
                            SELECT category_id, MIN(news_post_date) AS latest_post
                            FROM news
                            GROUP BY category_id
                        ) AS latest ON n.category_id = latest.category_id AND n.news_post_date = latest.latest_post;";
                $result = $conn->query($sql3);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <span class="ms-3 fs-4 fw-bold">' . htmlspecialchars($row['category_name']) . '</span>
                <div class="card">
                    <div class="image-preview">
                        <img class="card-img-top" src="' . $row['news_image_path'] . '" alt="News image">
                    </div>
                    <div class="card-body">
                        <div class="top">
                            <h5 class="card-title">' . htmlspecialchars($row['news_title']) . '</h5>
                            <div class="text-limit">
                                <p class="card-text">' . htmlspecialchars($row['news_description']) . '</p>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="views d-flex align-items-center gap-1 ">
                                <img src="\Quiz_website\templates\assets\images\visibility_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                                <p class="m-0">' . htmlspecialchars($row['news_views']) . '</p>
                            </div>
                            <div class="Post-date d-flex align-items-center ">
                                <p class="m-0">' . htmlspecialchars($row['news_post_date']) . '</p>
                            </div>
                            <button class="btn btn-primary">View more</button>
                        </div>
                    </div>
                </div>
                        ';
                    }
                } else {
                    echo "<p>Không có dữ liệu.</p>";
                }
                ?>

            </div>

        </div>
        <div class="right-container"></div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
// include_once 'templates\layout\user\footer.php';
?>