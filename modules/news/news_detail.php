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
    <?php require_once './templates/layout/user/categoryBar.php'; ?>
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