<?php

//home
layoutUser('header');
//Search handle
if (isMethodGet()) {
    $filterArr = filterData();

    if (isset($filterArr['searchKey'])) {
        $searchKey = $filterArr['searchKey'];
    } else {
        $searchKey = "";
    }


    //Pagination
    $sql1 = "SELECT * FROM news WHERE news_isPost=1";
    $stmt = $conn->prepare($sql1);
    if ($stmt === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt->execute();

    //Lấy kết quả
    $result1 = $stmt->get_result();
    $total_rows = $result1->num_rows;
    $stmt->close();
    $offset = 0;
    $perPage = 5; //tong so user/page
    $maxPage = ceil($total_rows  / $perPage); //tinh max page
    $filterArr = filterData('GET');
    $page = 1;
    if (isset($filterArr['page'])) {
        $page = $filterArr['page'];
    }

    if ($page > $maxPage || $page < 0) {
        $page = 1;
    }
    if (isset($page)) {
        $offset = ($page - 1) * $perPage;
    }

    $sql2 = "SELECT * FROM news 
         WHERE (news_title LIKE '%$searchKey%' OR news_summary LIKE '%$searchKey%')
         AND news_isPost = 1 
         ORDER BY news_post_date DESC 
         LIMIT $offset, $perPage";
    $stmt1 = $conn->prepare($sql2);
    if ($stmt1 === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt1->execute();

    //Lấy kết quả
    $result2 = $stmt1->get_result();
} else {
    $searchKey = "";
}



//query string 
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page=' . $page, '', $queryString);
}

//xử lý bảng rỗng
if (!empty($searchKey)) {
    $sql3 = "SELECT * FROM news 
         WHERE (news_title LIKE '%$searchKey%' OR news_summary LIKE '%$searchKey%')
         AND news_isPost = 1 
         ORDER BY news_post_date DESC";
    $stmt1 = $conn->prepare($sql3);
    if ($stmt1 === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt1->execute();

    //Lấy kết quả
    $result3 = $stmt1->get_result();
    $total_rows1 = $result3->num_rows;

    $maxPage = ceil($total_rows1 / $perPage);
}
?>
<main>
    <?php require './templates/layout/user/categoryBar.php'; ?>
    <div class="main container mt-3">
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
                            <div class="row align-items-center p-3">
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <img src="' . $row['news_image_path'] . '" alt="News image" class="rounded w-100" style="height:250px;object-fit:cover;">
                                </div>
                                <div class="col-12 col-md-6 ">
                                    <a class="fw-bold text-decoration-none fs-5" href="?module=news&action=news_detail&news_id=' . htmlspecialchars($row['news_id']) . '" >' . htmlspecialchars($row['news_title']) . ' </a>
                                    <div class="text-limit">
                                        <p class="text-muted mb-0">'
                                . htmlspecialchars($row['news_summary']) .
                                '</p>
                                    </div>
                                    <p class="mt-3 text-muted" style="font-size: 0.9rem;">Ngày đăng: ' . htmlspecialchars($row['news_post_date']) . '</p>
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

            </div>


        </div>
        <div class="bottom-container">
            <div class="left-content">
                <div class="news-card  ">
                    <?php
                    // $sql3 = "SELECT * FROM news WHERE news_isPost = 1 ORDER BY news_post_date DESC";
                    // $result = $conn->query($sql3);
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
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
                        echo '<div class="card d-flex justify-content-center w-100">';
                        echo '<div class="text-muted " style="font-size: 14px; text-align:center;">';
                        echo '<i class="bi bi-inbox fs-4 d-block mb-2 "></i>';
                        echo '<p>No data available</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
            <div class="right-content">
                <div class="search mt-4">
                    <form class="d-flex" action="" method="GET">
                        <input type="hidden" name="module" value="home">
                        <input type="hidden" name="action" value="index">
                        <div class="search-box me-2">
                            <img class="search-icon" src="/News_website/templates/assets/images/search_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                            <input name="searchKey" class="form-control" type="text" placeholder="Enter the title or summary news" aria-label="Search" value="<?= htmlspecialchars($searchKey) ?>">
                            <?php 
                                if($searchKey){
                                    echo '<a href="?module=home&action=index" class="reset-button">
                                            <img src="/News_website/templates/assets/images/close_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                                        </a>';
                                }
                            ?> 
                        </div>

                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <?php layoutUser('scrollBack') ?>

        </div>
        <!-- phan trang -->
        <div class="row mt-3">
            <nav aria-label="Page navigation example" class="d-flex align-items-center justify-content-center">
                <ul class="pagination">
                    <!-- prev button -->
                    <?php

                    if ($page > 1) {
                        echo '<li class="page-item"><a class="page-link rounded-0 rounded-start" href="?' . $queryString . '&page=' . ($page - 1) . '">Previous</a></li>';
                    }
                    $start = $page - 1;
                    if ($start < 1) {
                        $start = 1;
                    }
                    if ($start > 1) {
                        echo '<li class="page-item"><a class="page-link rounded-0" href="?' . $queryString . '&page=' . ($page - 1) . '">...</a></li>';
                    }

                    ?>
                    <?php
                    $end = $page + 1;
                    if ($end > $maxPage) {
                        $end = $maxPage;
                    }
                    ?>

                    <?php
                    for ($i = $start; $i <= $end; $i++) {

                        echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link rounded-0" href="?' . $queryString . '&page=' . $i . '">' . $i . '</a></li>';
                    }
                    ?>

                    <!-- next button -->
                    <?php

                    if ($end < $maxPage) {
                        echo '<li class="page-item"><a class="page-link rounded-0" href="?' . $queryString . '&page=' . ($page + 1) . '">...</a></li>';
                    }
                    if ($page < $maxPage) {
                        echo '<li class="page-item"><a class="page-link rounded-0 rounded-end" href="?' . $queryString . '&page=' . ($page + 1) . '">Next</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</main>
<?php
layoutUser('footer');
?>