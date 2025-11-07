<?php
include_once 'templates/layout/user/header.php';

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    $sql = "SELECT * FROM news n, category c WHERE n.category_id = c.category_id AND news_id = $news_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
$user_id = getSession('user_id');
?>

<main>
    <div class="container my-4">
        <h3 class="mb-4">Delete News</h3>
        <form action="?module=news&action=deleteNews_handle" method="POST" class="p-4 border rounded bg-light">
            <input type="hidden" name="news_id" value="<?= $news_id ?>">

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($row['category_name']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($row['news_title']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Summary</label>
                <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($row['news_summary']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <?php
                $content = $row['news_description']; // Lấy dữ liệu từ DB, ví dụ: &#60;p&#62;&#38;aacute;dasdasda&#60;/p&#62;

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
                    <img src="<?= htmlspecialchars($row['news_image_path']) ?>" alt="Current image" style="max-width: 200px">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image description</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($row['news_image_note']) ?>" disabled>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news&action=manageNews&user_id=<?php echo $user_id ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-danger">Delete News</button>
            </div>
        </form>
    </div>
</main>

<?php include_once 'templates/layout/user/footer.php'; ?>