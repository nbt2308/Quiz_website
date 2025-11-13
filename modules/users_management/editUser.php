<?php
$user_id;
$user_id_current = getSession("user_id");
$user_name_current = getSession("user_name");
if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];


    //validate username
    if (empty(trim($filterArr['user_name']))) {
        $errors['user_name']['required'] = "Username is required";
    } else {
        if (strlen(trim($filterArr['user_name'])) < 5) {
            $errors['user_name']['length'] = "Username must be 5 characters long";
        }
    }
    //validate address
    if (empty(trim($filterArr['user_address']))) {
        $errors['user_address']['required'] = "Address is required";
    } else {
        if (strlen(trim($filterArr['user_address'])) < 6) {
            $errors['user_address']['length'] = "Address must be 6 characters long";
        }
    }
    $save_content = $conn->real_escape_string($filterArr['user_bio']);
    if (empty($errors)) {
        //not found error
        //transfer data
        //image
        $news_image_path = '';
        if (!empty($_FILES['user_image']['name'])) {
            $targetDir = 'templates/uploads/';
            $targetFile = $targetDir . $news_title . "_" . basename($_FILES['user_image']['name']);
            if (move_uploaded_file($_FILES['user_image']['tmp_name'], $targetFile)) {
                $news_image_path = $targetFile;
            } else {
                die("Không thể upload ảnh!");
            }
            $data = [
                'user_name' => $filterArr['user_name'],
                'user_role' => $filterArr['user_role'],
                'user_status' => $filterArr['user_status'],
                'user_address' => $filterArr['user_address'],
                'user_bio' => $save_content,
                'user_image' => $news_image_path,
            ];

            $sql = "UPDATE user 
                    SET    user_name=?,
                           user_role=?,
                           user_status=?,
                           user_address=?,
                           user_bio=?,
                           user_image_path=?
                    WHERE   user_id='$user_id'";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Loi prepare SQL: " . $conn->error);
            }

            //bind dữ liệu theo câu lệnh insert ở trên
            $stmt->bind_param(
                "siisss", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
                $data['user_name'],
                $data['user_role'],
                $data['user_status'],
                $data['user_address'],
                $data['user_bio'],
                $data['user_image'],
            );
            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
        } else {
            $data_without_image = [
                'user_name' => $filterArr['user_name'],
                'user_role' => $filterArr['user_role'],
                'user_status' => $filterArr['user_status'],
                'user_address' => $filterArr['user_address'],
                'user_bio' => $save_content,
            ];

            $sql = "UPDATE user 
                    SET    user_name=?,
                           user_role=?,
                           user_status=?,
                           user_address=?,
                           user_bio=?
                    WHERE  user_id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Loi prepare SQL: " . $conn->error);
            }

            //bind dữ liệu theo câu lệnh insert ở trên
            $stmt->bind_param(
                "siissi", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
                $data_without_image['user_name'],
                $data_without_image['user_role'],
                $data_without_image['user_status'],
                $data_without_image['user_address'],
                $data_without_image['user_bio'],
                $user_id
            );
            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
        }

        if ($insert_success) {
            header("Location:?module=users_management&action=listUser&user_id=$user_id");
        } else {
            setSessionFlash('msg', 'Invalid data, please check again');
            setSessionFlash('msg_type', 'danger');
        }
        $stmt->close();
    } else {
        setSessionFlash('msg', 'Invalid data, please check again');
        setSessionFlash('msg_type', 'danger');
        setSessionFlash('oldData', $filterArr);
        setSessionFlash('errors', $errors);
    }

    $oldData = getSessionFlash('oldData');
    $errorsArr = getSessionFlash('errors');
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
} else {
    $msg = "";
    $msg_type = '';
    $oldData = "";
    $errorsArr = "";
}

//header
$dataTitle = [
    'title' => "Edit user",
    'breadcrumb' => "List Users",
    'data' => $user_name_current,
    'module' => 'users_management',
    'action' => 'listUser'
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
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Email address (<span class="text-danger">It cannot be changed here</span>)</label>
                                <input type="text" name="user_email" class="form-control"
                                    id="exampleFormControlInput1" placeholder="Enter email address" disabled value="<?= htmlspecialchars($data['user_email']) ?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Password (<span class="text-danger">It cannot be changed here</span>)</label>
                                <input type="password" name="user_password" class="form-control" id="exampleFormControlInput1" placeholder="Enter password" disabled>
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Username (<span class="text-danger">*</span>)</label>
                                <input type="text" name="user_name" class="form-control"
                                    id="exampleFormControlInput1" placeholder="Enter username" require value="<?= htmlspecialchars($data['user_name']) ?>">
                                <?php
                                echo formErrors($errorsArr, 'user_name');
                                ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Select role for user (<span class="text-danger">*</span>)</label>
                                <select class="form-select " name="user_role" aria-label=".form-select-lg example" require>
                                    <?php
                                    if (htmlspecialchars($data['user_role']) == 1) {
                                        echo '<option value="0">User</option>
                                                      <option selected value="1">Admin</option>';
                                    } else if (htmlspecialchars($data['user_role']) == 0) {
                                        echo '<option selected value="0">User</option>
                                                      <option value="1">Admin</option>';
                                    }

                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_status" class="form-label fw-bold">Select status for user (<span class="text-danger">*</span>)</label>
                                <select name="user_status" id="user_status" class="form-select">
                                    <?php
                                    if (htmlspecialchars($data['user_status']) == 1) {
                                        echo '<option value="0">Pending</option>
                                                  <option selected value="1">Activated</option>';
                                    } else if (htmlspecialchars($data['user_status']) == 0) {
                                        echo '<option selected value="0">Pending</option>
                                                  <option value="1">Activated</option>';
                                    }

                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_address" class="form-label fw-bold">Address (<span class="text-danger">*</span>)</label>
                                <input name="user_address" id="user_address" type="text"
                                    class="form-control" placeholder="Enter address" require value="<?= htmlspecialchars($data['user_address']) ?>">
                                <?php
                                echo formErrors($errorsArr, 'user_address');
                                ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="user_bio" class="form-label fw-bold">Bio</label>
                                <?php
                                $content = $data['user_bio']; // Lấy dữ liệu từ DB, ví dụ: &#60;p&#62;&#38;aacute;dasdasda&#60;/p&#62;

                                // Giải mã 2 lần
                                $decoded = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                ?>
                                <textarea name="user_bio" id="user_bio" class="form-control" rows="5" placeholder="Enter bio"><?php echo $decoded ?></textarea>
                                <script>
                                    CKEDITOR.replace('user_bio');
                                </script>
                            </div>
                        </div>

                        <!-- Hình ảnh -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="formFileLg" class="form-label fw-bold">Upload a user image (<span class="text-danger">*</span>)</label>
                                <input name="user_image" class="form-control" id="formFileLg" type="file">
                                <div class="mb-2">
                                    <p>Current image:</p>
                                    <img src="<?= htmlspecialchars($data['user_image_path']); ?>" alt="Current image" width="300" height="auto">
                                </div>
                            </div>
                        </div>
                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="?module=users_management&action=listUser&user_id=<?php echo $user_id_current; ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Edit user</button>
                        </div>
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