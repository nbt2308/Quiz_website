<?php
layoutUser('header');

//validate data
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];
    //validate category name
    if (empty(trim($filterArr['category_name']))) {
        $errors['category_name']['required'] = "Category name is required";
    } else {
        if (strlen(trim($filterArr['category_name'])) < 3) {
            $errors['category_name']['length'] = "Category name must be 3 characters long";
        }
    }

    if (empty($errors)) {
        $data = ['category_name' => $filterArr['category_name']];
        $sql = "INSERT INTO category (category_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }
        $stmt->bind_param(
            "s", //định dạng kiểu dữ liệu string
            $data['category_name']
        );
        //lưu vào biến để kiểm tra trạng thái
        $insert_success = $stmt->execute();
        if ($insert_success) {
            header("Location: ?module=news_category&action=listNewsCategory");
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
        <h3 class="mb-4 text-center fw-bold">Add News Category Name</h3>
        <form action="" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">

            <!-- Chủ đề tin -->
            <div class="mb-3">
                <label for="category_name" class="form-label fw-bold">News category name</label>
                <input name="category_name" id="category_name" type="text" class="form-control" placeholder="Enter news category name">
                <?php
                echo formErrors($errorsArr, 'category_name');
                ?>
            </div>

            <!-- Nút hành động -->
            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news_category&action=listNewsCategory" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Add news category name</button>
            </div>
        </form>
    </div>
</main>

<?php
layoutUser('footer');
?>