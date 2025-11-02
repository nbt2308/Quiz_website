<?php
include_once 'templates/layout/user/header.php';
?>

<main>
  <div class="container my-4">
    <h3 class="mb-4">Add News</h3>
    <form action="?module=news&action=addNews_handle" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">

      <!-- Chọn danh mục -->
      <div class="mb-3">
        <label for="category" class="form-label">Select category</label>
        <select name="category" id="category" class="form-select" required>
          <option selected disabled>-- Select a category --</option>
          <?php
          $sql = "SELECT * FROM category";
          $list = mysqli_query($conn, $sql);
          if ($list && $list->num_rows > 0) {
            while ($row = $list->fetch_assoc()) {
              echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
            }
          }
          ?>
        </select>
      </div>

      <!-- Tiêu đề tin -->
      <div class="mb-3">
        <label for="news_title" class="form-label">News title</label>
        <input name="news_title" id="news_title" type="text" class="form-control" placeholder="Enter news title" required>
      </div>

      <!-- Tóm tắt -->
      <div class="mb-3">
        <label for="news_summary" class="form-label">News summary</label>
        <input name="news_summary" id="news_summary" type="text" class="form-control" placeholder="Enter short summary">
      </div>

      <!-- Nội dung -->
      <div class="mb-3">
        <label for="news_content" class="form-label">News content</label>
        <textarea name="news_content" id="news_content" class="form-control" rows="5" placeholder="Enter content here"></textarea>
      </div>

      <!-- Hình ảnh -->
      <div class="mb-3">
        <label for="formFileLg" class="form-label">Upload a news image</label>
        <input name="image_file" class="form-control" id="formFileLg" type="file">
      </div>

      <!-- Mô tả hình ảnh -->
      <div class="mb-3">
        <label for="image_description" class="form-label">Image description</label>
        <input name="image_description" id="image_description" type="text" class="form-control" placeholder="Enter image description">
      </div>

      <!-- Nút hành động -->
      <div class="d-flex justify-content-between mt-4">
        <a href="?module=news&action=manageNews" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Add news</button>
      </div>
    </form>
  </div>
</main>

<?php
include_once 'templates/layout/user/footer.php';
?>