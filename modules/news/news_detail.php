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
        $sql1 = "SELECT * FROM news, user WHERE news_id='$news_id'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        if ($row1) {
            echo '
        <article class="p-4 p-md-5 rounded-4 shadow-sm">
            <header class="mb-5 text-center border-bottom pb-4">
                <h1 class="fw-bold mb-3 display-6 text-dark">' . htmlspecialchars($row1['news_title']) . '</h1>

                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 text-muted small">
                    <span class="d-flex align-items-center gap-1">
                        <i class="bi bi-person-circle"></i>
                        <span><strong>' . htmlspecialchars($row1['user_name']) . '</strong></span>
                    </span>

                    <span class="vr d-none d-md-block"></span> <!-- đường kẻ dọc chia giữa các info -->

                    <span class="d-flex align-items-center gap-1">
                        <i class="bi bi-eye"></i>
                        <span>' . number_format((int)$row1['news_views']) . ' views</span>
                    </span>

                    <span class="vr d-none d-md-block"></span>

                    <span class="d-flex align-items-center gap-1">
                        <i class="bi bi-calendar3"></i>
                        <span>' . date("F j, Y", strtotime($row1['news_post_date'])) . '</span>
                    </span>
                </div>

                <p class="lead text-secondary mt-4 fst-italic">' . htmlspecialchars($row1['news_summary']) . '</p>
            </header>

            <figure class="text-center mb-4">
                <img src="' . htmlspecialchars($row1['news_image_path']) . '" 
                     class="img-fluid rounded-4 shadow-sm figure w-100" 
                     alt="News image" style="max-width: 600px; height: auto;">
                <figcaption class="text-secondary mt-2 fst-italic small">' . htmlspecialchars($row1['news_image_note']) . '</figcaption>
            </figure>';

            // Decode nội dung
            $decoded = html_entity_decode($row1['news_description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            echo '<section class="article-content fs-6 lh-lg text-justify px-md-4">
                ' . $decoded . '
              </section>';

            echo '<div class="text-center mt-5">
                <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                    <i class="bi bi-arrow-left"></i> Go back
                </button>
              </div>
        </article>';
        } else {
            echo '<p class="text-danger text-center mt-5">Article not found.</p>';
        }
        ?>
    </div>
</main>
<?php
layoutUser("footer");
?>