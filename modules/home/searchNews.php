<?php

//home
layoutUser('header');
if (isMethodPost('POST')) {
    $searchKey = $_POST['searchKey'];
}
?>
<main>
    <div class="category container">
        <?php
        $sql = "SELECT * FROM category";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="category-title">
                        <a href="?module=news_category&action=index&category_id=' . htmlspecialchars($row['category_id']) . '"><strong>' . htmlspecialchars($row['category_name']) . '</strong></a>
                    </div>
        ';
            }
        } else {
            echo '<div class="text-muted " style="font-size: 14px; text-align:center;">';
            echo '<i class="bi bi-inbox fs-4 d-block mb-2 "></i>';
            echo '<p>No data available</p>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="main container my-3">
        <div class="top-container ">


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
                            ) vmax ON n.category_id = vmax.category_id AND n.news_post_date = vmax.latest_post
                            WHERE n.news_isPost = 1;";

                    $result = $conn->query($sql2);
                    if ($result->num_rows > 0) {
                        $isActive = true;
                        while ($row = $result->fetch_assoc()) {
                            echo '
                    <div class="carousel-item ' . ($isActive ? 'active' : '') . '">
                        <div class="d-flex align-items-center p-3">
                            <div style="height:100%;width:auto;"><img src="' . $row['news_image_path'] . '" alt="News image" class="rounded me-3" style="width:400px;height:250px;object-fit:cover;"></div>
                            <div class="ms-3">
                                <a class="fw-bold text-decoration-none" href="#" >' . htmlspecialchars($row['news_title']) . ' </a>
                                <div class="text-limit">
                                    <p class="text-muted mb-0">'
                                . htmlspecialchars($row['news_summary']) .
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
                        echo '<div class="text-muted " style="font-size: 14px; text-align:center;">';
                        echo '<i class="bi bi-inbox fs-4 d-block mb-2 "></i>';
                        echo '<p>No data available</p>';
                        echo '</div>';
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
                <!-- <div class="carousel-indicators mt-3">
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="2"></button>
                </div> -->
            </div>


        </div>
        <div class="bottom-container">
            <div class="left-content">
                <div class="news-card  ">
                    <?php
                    $sql3 = "SELECT * FROM news WHERE news_title LIKE '%$searchKey%' OR news_summary LIKE '%$searchKey%'";
                    $result = $conn->query($sql3);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                         
                <div class="card">
                    <div class="image-preview">
                        <img class="card-img-top" src="' . $row['news_image_path'] . '" alt="News image" />
                    </div>
                    <div class="card-body">
                        <div class="top">
                            <h5 class="card-title">' . htmlspecialchars($row['news_title']) . '</h5>
                            <div class="text-limit">
                                <p class="card-text">' . htmlspecialchars($row['news_summary']) . '</p>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="views d-flex align-items-center gap-1 ">
                                <img src="/News_website/templates/assets/images/visibility_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                                <p class="m-0">' . htmlspecialchars($row['news_views']) . '</p>
                            </div>
                            <div class="Post-date d-flex align-items-center ">
                                <p class="m-0">' . htmlspecialchars($row['news_post_date']) . '</p>
                            </div>
                            <a href="?module=news&action=news_detail&news_id=' . htmlspecialchars($row['news_id']) . '" class="btn btn-primary">View more</a>
                        </div>
                    </div>
                </div>
                        ';
                        }
                    } else {
                        echo '<div class="w-100 text-center py-4">';
                        echo '<div class="text-muted" style="font-size: 15px;">';
                        echo '<i class="bi bi-search fs-4 d-block mb-2"></i>';
                        echo 'No results found for "<strong>' . htmlspecialchars($searchKey) . '</strong>"';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
            <div class="right-content ">
                <div class="search mt-4">
                    <form class="d-flex" action="?module=home&action=searchNews" method="POST">
                        <div class="search-box me-2">
                            <img class="search-icon" src="/News_website/templates/assets/images/search_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                            <input name="searchKey" class="form-control" type="text" value="<?php echo $searchKey ?>" placeholder="Enter the title or summary news" aria-label="Search">
                            <a href="?module=home&action=index" class="reset-button">
                                <img src="/News_website/templates/assets/images/close_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                            </a>
                        </div>
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>


            </div>
        </div>
    </div>
</main>
<?php
layoutUser('footer');
?>