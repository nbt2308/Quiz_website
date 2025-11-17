<?php
layoutUser("header");
$category_id;

if (!empty($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}
// echo $category_id;
//Pagination
$sql1 = "SELECT * FROM news";
$stmt = $conn->prepare($sql1);
if ($stmt === false) {
    die("Loi prepare SQL: " . $conn->error);
}
$stmt->execute();

//Lấy kết quả
$result = $stmt->get_result();
$total_rows = $result->num_rows;
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

$sql2 = "SELECT * 
         FROM news 
         WHERE category_id='$category_id' 
         AND news_isPost=1
         ORDER BY news_id DESC 
         LIMIT $offset, $perPage";
$stmt1 = $conn->prepare($sql2);
if ($stmt1 === false) {
    die("Loi prepare SQL: " . $conn->error);
}
$stmt1->execute();

//Lấy kết quả
$result2 = $stmt1->get_result();
//query string 
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page=' . $page, '', $queryString);
}

$sql3 = "SELECT * 
         FROM news 
         WHERE category_id='$category_id' 
         AND news_isPost=1
         ORDER BY news_id DESC";
$stmt1 = $conn->prepare($sql3);
if ($stmt1 === false) {
    die("Loi prepare SQL: " . $conn->error);
}
$stmt1->execute();

//Lấy kết quả
$result3 = $stmt1->get_result();
$total_rows1 = $result3->num_rows;

$maxPage = ceil($total_rows1 / $perPage);

?>
<main>
    <?php require_once './templates/layout/user/categoryBar.php'; ?>
    <div class="main-container container">
        <?php
        //in ten chu de
        $sql1 = "SELECT * FROM category WHERE category.category_id='$category_id'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        echo  '<span class="ms-3 fs-4 fw-bold">' . htmlspecialchars($row1['category_name']) . '</span>';
        //in nhung bai viet
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                echo ' <div class="news-card my-3">
              
                       
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
        <?php layoutUser('scrollBack') ?>
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
layoutUser("footer");
?>