<?php
layoutUser('header');

$user_id = getSession('user_id');

//validate data
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];
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
        $errors['image_file']['required'] = "Please upload an image for your post";
    }
    //validate image note
    if (empty(trim($filterArr['image_description']))) {
        $errors['image_description']['required'] = "Image description is required";
    } else {
        if (strlen(trim($filterArr['image_description'])) < 10) {
            $errors['image_description']['length'] = "Image description must be 10 characters long";
        }
    }

    if (empty($errors)) {
        //Xử lý dữ liệu image file thành đường dẫn
        $news_image_path = '';
        if (!empty($_FILES['image_file']['name'])) {
            $targetDir = 'templates/uploads/';
            $targetFile = $targetDir . $news_title . "_" . basename($_FILES['image_file']['name']);
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
                $news_image_path = $targetFile;
            } else {
                die("Không thể upload ảnh!");
            }
        }
        //Xử lý dữ liệu từ input có áp dụng ckeditor
        // $save_content = $conn->real_escape_string($filterArr['news_content']);
        //lấy user id từ session
        $user_id = getSession('user_id');
        $data = [
            'category_id' => $filterArr['category'],
            'news_title' => $filterArr['news_title'],
            'news_summary' => $filterArr['news_summary'],
            'news_description' => $filterArr['news_content'],
            'news_image_path' => $news_image_path,
            'news_image_note' => $filterArr['image_description'],
            'user_id' => $user_id
        ];
        $sql = "INSERT INTO news (news_title, news_summary, news_description, news_image_path, news_image_note, user_id, category_id) 
        VALUES (?, ?, ?, ?, ?, ? ,? )";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }
        $stmt->bind_param(
            "sssssii", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
            $data['news_title'],
            $data['news_summary'],
            $data['news_description'],
            $data['news_image_path'],
            $data['news_image_note'],
            $data['user_id'],
            $data['category_id'],
        );
        //lưu vào biến để kiểm tra trạng thái
        $insert_success = $stmt->execute();
        if ($insert_success) {
            header("Location: ?module=news&action=manageNews&user_id=$user_id");
        }
    } else {
        setSessionFlash('oldData', $filterArr);
        setSessionFlash('errors', $errors);
    }
    $oldData = getSessionFlash('oldData');
    $errorsArr = getSessionFlash('errors');
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
                <?php
                echo formErrors($errorsArr, 'news_title');
                ?>
            </div>

            <!-- Tóm tắt -->
            <div class="mb-3">
                <label for="news_summary" class="form-label fw-bold">News summary</label>
                <input name="news_summary" id="news_summary" type="text" class="form-control" placeholder="Enter short summary">
                <?php
                echo formErrors($errorsArr, 'news_summary');
                ?>
            </div>

            <!-- Nội dung -->
            <div class="mb-3">
                <label for="news_content" class="form-label fw-bold">News content</label>
                <textarea name="news_content" id="news_content" class="form-control" rows="5" placeholder="Enter content here"></textarea>
                <script>
                    CKEDITOR.replace('news_content');
                </script>
                <?php
                echo formErrors($errorsArr, 'news_content');
                ?>
            </div>

            <!-- Hình ảnh -->
            <div class="mb-3">
                <label for="formFileLg" class="form-label fw-bold">Upload a news image</label>
                <input name="image_file" class="form-control" id="formFileLg" type="file">
                <?php
                echo formErrors($errorsArr, 'image_file');
                ?>
            </div>

            <!-- Mô tả hình ảnh -->
            <div class="mb-3">
                <label for="image_description" class="form-label fw-bold">Image description</label>
                <input name="image_description" id="image_description" type="text" class="form-control" placeholder="Enter image description">
                <?php
                echo formErrors($errorsArr, 'image_description');
                ?>
            </div>

            <!-- Nút hành động -->
            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news&action=manageNews&user_id=<?php echo $user_id ?>" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Add news</button>
            </div>
        </form>
    </div>
</main>

<?php
layoutUser('footer');
?>