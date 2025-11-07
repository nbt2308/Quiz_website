<?php
include_once 'templates/layout/user/header.php';

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    $sql = "SELECT * 
            FROM news n, category c
            WHERE n.category_id = c.category_id AND n.news_id = $news_id";
    $result = $conn->query($sql);
    if (!$result || $result->num_rows == 0) {
        echo "News not found";
        exit;
    }
    $news = $result->fetch_assoc();
}
$user_id = getSession('user_id');
?>

<main>
    <div class="container my-4">
        <h3 class="mb-4">View News</h3>

        <div class="p-4 border rounded bg-light">

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($news['category_name']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($news['news_title']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Summary</label>
                <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($news['news_summary']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <?php
                $content = $news['news_description']; // Lấy dữ liệu từ DB, ví dụ: &#60;p&#62;&#38;aacute;dasdasda&#60;/p&#62;

                // Giải mã 2 lần
                $decoded = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                ?>
                <!-- <textarea class="form-control" rows="5" disabled><?php echo $decoded; ?></textarea> -->
                <div style="border:1px solid #ccc; padding:10px; border-radius:5px; background-color: #e9ecef;">
                    <?php echo $decoded; ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label><br>
                <img width="500" height="auto" src="<?= $news['news_image_path'] ?>" class="img-fluid" alt="News Image">
            </div>

            <div class="mb-3">
                <label class="form-label">Image Description</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($news['news_image_note']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Post Date</label>
                <input type="text" class="form-control" value="<?= $news['news_post_date'] ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Views</label>
                <input type="text" class="form-control" value="<?= $news['news_views'] ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control" value="<?= $news['news_isPost'] ? 'Approved' : 'Not approved' ?>" disabled>
            </div>

            <a href="?module=news&action=manageNews&user_id=<?php echo $user_id ?>" class="btn btn-secondary mt-3">Back</a>

        </div>
    </div>
</main>

<?php include_once 'templates/layout/user/footer.php'; ?>