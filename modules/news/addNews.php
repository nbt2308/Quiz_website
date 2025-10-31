<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add News</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="\Quiz_website\templates\assets\css\home\style.css">
</head>

<body>
  <div class="modal fade fs-5" id="modalAddNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add news</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="?module=news&action=addNews_xuly" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <select name="category" class="form-select form-select-lg mb-3">
              <option selected disabled> -- Select a category-- </option>
              <?php
              $sql = "SELECT * FROM category";
              $list = mysqli_query($conn, $sql);
              if ($list->num_rows > 0) {
                while ($row = $list->fetch_assoc()) {
                  echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
                }
              }
              ?>
            </select>
            <div class="form-floating mb-3">
              <input name="news_title" type="text" class="form-control" id="floatingInput" placeholder="news-title">
              <label for="floatingInput">News title</label>
            </div>
            <div class="form-floating mb-3">
              <input name="news_summary" type="text" class="form-control" id="floatingInput" placeholder="news-summary">
              <label for="floatingInput">News summary</label>
            </div>
            <div class="form-floating mb-3">
              <textarea name="news_content" class="form-control" placeholder="news-content" id="floatingTextarea2" style="height: 100px"></textarea>
              <label for="floatingTextarea2">News content</label>
            </div>
            <div>
              <label for="formFileLg" class="form-label">Upload a news image</label>
              <input name="image_file" class="form-control form-control-lg mb-3" id="formFileLg" type="file">
            </div>
            <div class="form-floating mb-3">
              <input name="image_description" type="text" class="form-control" id="floatingInput" placeholder="image-description">
              <label for="floatingInput">Image description</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add news</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>