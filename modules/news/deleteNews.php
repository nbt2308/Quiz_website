<?php
include_once 'templates/layout/user/header.php';

if (isset($_GET['id'])) {
    $news_id = (int)$_GET['id'];
    $sql1 = "SELECT * FROM news WHERE news_id = $news_id";
    $result1 = $conn->query($sql1);
    $news = $result1->fetch_assoc();

    $category_id = $news['category_id'];
    $sql2 = "SELECT * FROM category WHERE category_id = $category_id";
    $result2 = $conn->query($sql2);
    $category = $result2->fetch_assoc();
}
?>

<main>
    <div class="container my-4">
        <h3 class="mb-4">Delete News</h3>
        <form action="?module=news&action=deleteNews_handle" method="POST" class="p-4 border rounded bg-light">
            <input type="hidden" name="news_id" value="<?= $news['news_id'] ?>">

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($category['category_name']) ?>" disabled>
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
                <div class="mb-2">
                    <p>Current image:</p>
                    <img src="<?= htmlspecialchars($news['news_image_path']) ?>" alt="Current image" style="max-width: 200px">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image description</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($news['news_image_note']) ?>" disabled>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news&action=manageNews" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-danger">Delete News</button>
            </div>
        </form>
    </div>
</main>

<?php include_once 'templates/layout/user/footer.php'; ?>