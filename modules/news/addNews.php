<?php
layoutUser('header');

//validate data
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];
    echo '<pre>';
    print_r($filterArr);
    echo '</pre>';
    //validate select category
    if (empty($filterArr['category'])) {
        $errors['category']['required'] = "Please select category";
    }
    //validate news title
    if (empty(trim($filterArr['news_title']))) {
        $errors['news_title']['required'] = "News title is required";
    } else {
        if (strlen(trim($filterArr['news_title'])) < 10) {
            $errors['news_title']['length'] = "News title must be 10 characters long";
        }
    }
    //validate news summary
    if (empty(trim($filterArr['news_summary']))) {
        $errors['news_summary']['required'] = "News summary is required";
    } else {
        if (strlen(trim($filterArr['news_summary'])) < 10) {
            $errors['news_summary']['length'] = "News summary must be 10 characters long";
        }
    }
    //validate news content
    if (empty(strip_tags(trim($filterArr['news_content'])))) {
        $errors['news_content']['required'] = "News content is required";
    } else {
        if (strlen(strip_tags(trim($filterArr['news_content']))) < 50) {
            $errors['news_content']['length'] = "News content must be 50 characters long";
        }
    }
    //validate image
    if (empty($_FILES['image_file']['name'])) {
        $errors['image_file']['required'] = "Please upload a image for your post";
    } 
    //validate image note
    if(empty(trim($filterArr['image_description']))){
         $errors['image_description']['required'] = "Image description is required";
    }
    else{
        if(strlen(trim($filterArr['image_description']))<10){
            $errors['image_description']['length'] = "Image description must be 10 characters long";
        }
    }

    if(empty($errors)){
        
    }
} else {
    $msg = "";
    $msg_type = '';
    $oldData = "";
    $errorsArr = "";
}
?>

<main>
    <div class="container my-4">
        <h3 class="mb-4 text-center fw-bold">Add News</h3>
        <form action="" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">

            <!-- Chọn danh mục -->
            <div class="mb-3">
                <label for="category" class="form-label fw-bold">Select category</label>
                <select name="category" id="category" class="form-select">
                    <option selected disabled>-- Select a category --</option>
                    <?php
                    $sql = "SELECT * FROM category";
                    $list = $conn->query($sql);
                    if ($list && $list->num_rows > 0) {
                        while ($row = $list->fetch_assoc()) {
                            echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <?php
                echo formErrors($errorsArr, 'category');
                ?>
            </div>

            <!-- Tiêu đề tin -->
            <div class="mb-3">
                <label for="news_title" class="form-label fw-bold">News title</label>
                <input name="news_title" id="news_title" type="text" class="form-control" placeholder="Enter news title">
            </div>

            <!-- Tóm tắt -->
            <div class="mb-3">
                <label for="news_summary" class="form-label fw-bold">News summary</label>
                <input name="news_summary" id="news_summary" type="text" class="form-control" placeholder="Enter short summary">
            </div>

            <!-- Nội dung -->
            <div class="mb-3">
                <label for="news_content" class="form-label fw-bold">News content</label>
                <textarea name="news_content" id="news_content" class="form-control" rows="5" placeholder="Enter content here"></textarea>
                <script>
                    CKEDITOR.replace('news_content');
                </script>
            </div>

            <!-- Hình ảnh -->
            <div class="mb-3">
                <label for="formFileLg" class="form-label fw-bold">Upload a news image</label>
                <input name="image_file" class="form-control" id="formFileLg" type="file">
            </div>

            <!-- Mô tả hình ảnh -->
            <div class="mb-3">
                <label for="image_description" class="form-label fw-bold">Image description</label>
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
layoutUser('footer');
?>