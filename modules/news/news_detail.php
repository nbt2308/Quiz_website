<?php
layoutUser("header");
$news_id;

if (!empty($_GET['news_id'])) {
    $news_id = $_GET['news_id'];

    //Tăng số lượt xem của bài viết
    $sql = "UPDATE news
            SET    news_views=news_views + 1
            WHERE  news_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt->bind_param(
        "i", //định dạng kiểu dữ liệu: int
        $news_id
    );
    //lưu vào biến để kiểm tra trạng thái
    $insert_success = $stmt->execute();
}



?>
<main>
    <div class="category container">
        <?php
        $sql = "SELECT * FROM category LIMIT 8";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="category-title">
                        <a href="?module=news_category&action=index&category_id=' . htmlspecialchars($row['category_id']) . '"><strong>' . htmlspecialchars($row['category_name']) . '</strong></a>
                    </div>';
            }
        ?>
            <div class="dropdown-center" style="z-index: 1;">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    More
                </a>

                <!-- <span class="visually-hidden">Toggle Dropdown</span> -->
                </button>
                <ul class="dropdown-menu">
                    <?php
                    $sql = "SELECT * FROM category WHERE category_id>8";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<li><a class="dropdown-item" href="?module=news_category&action=index&category_id=' . htmlspecialchars($row['category_id']) . '">' . htmlspecialchars($row['category_name']) . '</a></li>';
                        }
                    } else {
                        echo '<div class="text-muted " style="font-size: 14px; text-align:center;">';
                        echo '<i class="bi bi-inbox fs-4 d-block mb-2 "></i>';
                        echo '<p>No data available</p>';
                        echo '</div>';
                    }
                    ?>

                </ul>
            </div>
        <?php
        }
        echo '<div class="text-muted " style="font-size: 14px; text-align:center;">';
        echo '<i class="bi bi-inbox fs-4 d-block mb-2 "></i>';
        echo '<p>No data available</p>';
        echo '</div>';
        ?>
    </div>
    <div class="main-container container">
        <?php
        //in ten chu de
        $sql1 = "SELECT * FROM news, user WHERE news_id='$news_id' AND news.user_id=user.user_id";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        echo  '<div class="d-flex justify-content-between">';
        echo        '<p class="text-start text-secondary"><b>Posted by</b> ' . $row1['user_name'] . ', views: ' . $row1['news_views'] . ' </p>';
        echo        '<p class="text-end text-secondary"> ' . $row1['news_post_date'] . ' </p>';
        echo  '</div>';
        echo  '<h3 class="title"> ' . $row1['news_title'] . ' </h3>';
        echo  '<p class="summary"> ' . $row1['news_summary'] . ' </p>';
        echo  '<div class="d-flex justify-content-center">';
        echo        '<img class="image img-fluid" height=auto width=500 src="' . $row1['news_image_path'] . '">';
        echo  '</div>';
        echo  '<p class="summary text-center"> <i>' . $row1['news_image_note'] . '</i> </p>';
        //giải mã ký tự từ db
        $decoded = html_entity_decode($row1['news_description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $decoded = html_entity_decode($row1['news_description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        echo  '<p class="content"> ' . $decoded . ' </p>';

        echo '<button type="button" class="btn btn-secondary mb-3" onclick="history.back()">Go back</button>';
        ?>
    </div>
    </div>
</main>
<?php
layoutUser("footer");
?>