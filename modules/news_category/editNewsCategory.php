<?php
$user_id_current = getSession("user_id");
$user_name_current = getSession("user_name");
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

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
            $errors['category_name']['length'] = "Category name must be 3 characters long";
        }
        $category_name = $filterArr['category_name'];
        $sql = "SELECT COUNT(*) AS total FROM category WHERE category_name='$category_name'";
        $result = $conn->query($sql);
        $checkCategoryName = $result->fetch_assoc()['total'];
        if ($checkCategoryName > 0) {
            $errors['category_name']['exist'] = "Category name already exists";
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
            header("Location: ?module=news_category&action=listNewsCategory&user_id=$user_id_current");
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
//header
$dataTitle = [
    'title' => "Edit category",
    'breadcrumb' => "List Category",
    'data' => $user_name_current,
    'module' => 'news_category',
    'action' => 'listNewsCategory'
];
layoutAdminUseInclude("header", $dataTitle);
?>


<?php layoutAdmin("sidebar"); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->

        <?php layoutAdminUseInclude("breadcrumb", $dataTitle); ?>

        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content container">
        <!--begin::Container-->
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container-fluid">
                <!--begin::Row-->
                <?php getMsg($msg, $msg_type); ?>
                <form action="" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="row">
                        <div class="mb-3">
                            <label for="category_name" class="form-label fw-bold">News category name</label>
                            <input name="category_name" id="category_name" type="text" class="form-control" placeholder="Enter news category name" value="<?= htmlspecialchars($category['category_name']) ?>">
                            <?php
                            echo formErrors($errorsArr, 'category_name');
                            ?>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="?module=news_category&action=listNewsCategory&user_id=<?php echo $user_id_current; ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Edit category</button>
                        </div>
                </form>


                <!--end::Row-->

            </div>
            <!--end::Container-->
        </div>
    </div>
    <!--end::App Content-->
</main>
<!--end::App Main-->
<?php layoutAdmin("footer"); ?>