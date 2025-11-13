<?php

$user_id;
$user_id_current = getSession("user_id");
if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
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
        $category_name = $filterArr['category_name'];
        $sql = "SELECT COUNT(*) AS total FROM category WHERE category_name='$category_name'";
        $result = $conn->query($sql);
        $checkCategoryName = $result->fetch_assoc()['total'];
        if ($checkCategoryName > 0) {
            $errors['category_name']['exist'] = "Category name already exists";
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
            header("Location: ?module=news_category&action=listNewsCategory&user_id=$user_id");
            exit; // Luôn thêm exit sau header redirect
        } else {
            setSessionFlash('msg', 'Add new category failed');
            setSessionFlash('msg_type', 'danger');
        }
    } else {
        setSessionFlash('oldData', $filterArr);
        setSessionFlash('errors', $errors);
        setSessionFlash('msg', 'Invalid data, please check again');
        setSessionFlash('msg_type', 'danger');
    }
} 


$oldData = getSessionFlash('oldData') ?? [];
$errorsArr = getSessionFlash('errors') ?? [];
$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');

//header
$user_name = $data['user_name'];
$dataTitle = [
    'title' => "Add new category",
    'breadcrumb' => "List Category",
    'data' => $user_name,
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

               
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <form action="" method="POST" class="p-4">
                            <div class="mb-3">
                                <label for="category_name" class="form-label fw-bold">News category name (<span class="text-danger">*</span>)</label>
                               
                                <input name="category_name" id="category_name" type="text" class="form-control" 
                                       placeholder="Enter news category name" 
                                       value="<?php echo htmlspecialchars($oldData['category_name'] ?? ''); ?>" 
                                       required>
                                <?php
                                echo formErrors($errorsArr, 'category_name');
                                ?>
                            </div>

                            <!-- Nút hành động -->
                            <div class="d-flex justify-content-between gap-2 mt-4">
                                <a href="?module=news_category&action=listNewsCategory&user_id=<?php echo $user_id_current; ?>" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>


                <!--end::Row-->

            </div>
            <!--end::Container-->
        </div>
    </div>
    <!--end::App Content-->
</main>
<!--end::App Main-->
<?php layoutAdmin("footer"); ?>