<?php
include_once 'templates/layout/user/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM news WHERE news_id = $id";
    $result = $conn->query($sql);
    $news = $result->fetch_assoc();
}

?>

<main>
    <div class="container my-4">
        <h3 class="mb-4">Edit News</h3>
        <form action="?module=news&action=editNews_handle" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
            <input type="hidden" name="news_id" value="<?= $news['news_id'] ?>">
            <!-- Chọn danh mục -->
            <div class="mb-3">
                <label for="category" class="form-label">Select category</label>
                <select name="category" id="category" class="form-select">
                    <?php
                    $sql = "SELECT * FROM category";
                    $categories = $conn->query($sql);
                    while ($row = $categories->fetch_assoc()) {
                        $selected = ($row['category_id'] == $news['category_id']) ? 'selected' : '';
                        echo '<option value="' . $row['category_id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Tiêu đề tin -->
            <div class="mb-3">
                <label for="news_title" class="form-label">News title</label>
                <input name="news_title" id="news_title" type="text" class="form-control" placeholder="Enter news title" value="<?= htmlspecialchars($news['news_title']) ?>">
            </div>

            <!-- Tóm tắt -->
            <div class="mb-3">
                <label for="news_summary" class="form-label">News summary</label>
                <input name="news_summary" id="news_summary" type="text" class="form-control" placeholder="Enter short summary" value="<?= htmlspecialchars($news['news_summary']) ?>">
            </div>

            <!-- Nội dung -->
            <div class="mb-3">
                <label for="news_content" class="form-label">News content</label>
                <textarea name="news_content" id="news_content" class="form-control" rows="5" placeholder="Enter content here"><?= htmlspecialchars($news['news_description']) ?></textarea>
            </div>

            <!-- Hình ảnh -->
            <div class="mb-3">
                <label for="formFileLg" class="form-label">Upload a news image</label>
                <input name="image_file" class="form-control" id="formFileLg" type="file">
                <div class="mb-2">
                    <p>Current image:</p>
                    <img src="<?= htmlspecialchars($news['news_image_path']) ?>" alt="Current image" style="max-width: 200px">
                </div>
            </div>

            <!-- Mô tả hình ảnh -->
            <div class="mb-3">
                <label for="image_description" class="form-label">Image description</label>
                <input name="image_description" id="image_description" type="text" class="form-control" placeholder="Enter image description" value="<?= htmlspecialchars($news['news_image_note']) ?>">
            </div>

            <!-- Nút hành động -->
            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news&action=manageNews" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Edit news</button>
            </div>
        </form>
    </div>
</main>

<?php
include_once 'templates/layout/user/footer.php';
?>