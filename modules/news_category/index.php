<?php
layoutUser("header");
$category_id;

if (!empty($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}
// echo $category_id;
?>
<main>
    <?php layoutUser('categoryBar')?>
    <div class="main-container container">
        <?php
        //in ten chu de
        $sql1 = "SELECT * FROM category WHERE category.category_id='$category_id'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        echo  '<span class="ms-3 fs-4 fw-bold">' . htmlspecialchars($row1['category_name']) . '</span>';
        //in nhung bai viet
        $sql = "SELECT * FROM news WHERE news.category_id='$category_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
    </div>
</main>
<?php
layoutUser("footer");
?>