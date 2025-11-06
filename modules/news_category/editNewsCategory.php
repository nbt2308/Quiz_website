<?php
layoutUser('header');

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    $sql = "SELECT * FROM category WHERE category_id = '$category_id'";
    $result = $conn->query($sql);
    $category = $result->fetch_assoc();
}
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];

    //validate news title
    if (empty(trim($filterArr['category_name']))) {
        $errors['category_name']['required'] = "News category name is required";
    } else {
        if (strlen(trim($filterArr['category_name'])) < 3) {
            $errors['category_name']['length'] = "News category name must be 3 characters long";
        }
    }

    if (empty($errors)) {
        $data = [
            'category_name' => $filterArr['category_name'],
            'category_id' => $category_id
        ];
        $sql = "UPDATE category
                SET category_name = ?
                WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }
        $stmt->bind_param(
            "si", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
            $data['category_name'],
            $data['category_id']
        );
        //lưu vào biến để kiểm tra trạng thái
        $update_success = $stmt->execute();

        if ($update_success) {
            header("Location: ?module=news_category&action=listNewsCategory");
        } else {
            setSessionFlash('msg', 'Invalid data, please check again');
            setSessionFlash('msg_type', 'danger');
        }
    } else {
        setSessionFlash('oldData', $filterArr);
        setSessionFlash('errors', $errors);
    }
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
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
        <h3 class=" text-center">Edit News Category Name</h3>
        <?php getMsg($msg, $msg_type); ?>
        <form action="" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
            <!-- Chủ đề tin -->
            <div class="mb-3">
                <label for="category_name" class="form-label">News category name</label>
                <input name="category_name" id="category_name" type="text" class="form-control" placeholder="Enter news category name" value="<?= htmlspecialchars($category['category_name']) ?>">
                <?php
                echo formErrors($errorsArr, 'category_name');
                ?>
            </div>

            <!-- Nút hành động -->
            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news_category&action=listNewsCategory" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Edit category name</button>
            </div>
        </form>
    </div>
</main>

<?php
include_once 'templates/layout/user/footer.php';
?>