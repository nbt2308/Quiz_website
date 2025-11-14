<?php
$user_id;
$user_id_current = getSession("user_id");
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
    //validate email
    if (empty(trim($filterArr['user_email']))) {
        $errors['user_email']['required'] = "Email is required";
    } else {
        //correct format
        if (!validateEmail(trim($filterArr['user_email']))) {
            $errors['user_email']['isEmail'] = "Email is invalid";
        }
        //Email already exists in db
        else {
            $email = $filterArr['user_email'];
            $sql = "SELECT COUNT(*) AS total FROM user WHERE user_email='$email'";
            $result = $conn->query($sql);
            $checkMail = $result->fetch_assoc()['total'];
            if ($checkMail > 0) {
                $errors['user_email']['exist'] = "Email already exists";
            }
        }
    }
    //validate password
    if (empty(trim($filterArr['user_password']))) {
        $errors['user_password']['required'] = "Password is required";
    } else {
        if (strlen(trim($filterArr['user_password'])) < 6) {
            $errors['user_password']['length'] = "Password must be 6 characters long";
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
    //validate image
    if (empty($_FILES['user_image']['name'])) {
        $errors['user_image']['required'] = "Please upload an image for user";
    }
    if (empty($errors)) {
        //not found error
        //transfer data
        //image
        $news_image_path = '';
        if (!empty($_FILES['user_image']['name'])) {
            $targetDir = 'templates/uploads/';
            // VẤN ĐỀ: $news_title không tồn tại ở đây, có thể đây là code copy/paste. 
            // Tạm thời sửa bằng user_name để tránh lỗi.
            $username_safe = preg_replace("/[^a-zA-Z0-9]/", "_", $filterArr['user_name']);
            $targetFile = $targetDir . $username_safe . "_" . basename($_FILES['user_image']['name']);
            
            if (move_uploaded_file($_FILES['user_image']['tmp_name'], $targetFile)) {
                $news_image_path = $targetFile;
            } else {
                die("Không thể upload ảnh!");
            }
        }
        $data = [
            'user_email' => $filterArr['user_email'],
            'user_name' => $filterArr['user_name'],
            'user_password' => md5($filterArr['user_password']),
            'user_role' => $filterArr['user_role'],
            'user_status' => $filterArr['user_status'],
            'user_address' => $filterArr['user_address'],
            'user_bio' => $filterArr['user_bio'],
            'user_image' => $news_image_path, // LƯU Ý: Tên key 'user_image'
            'user_created_at' => date('Y-m-d H:i:s')
        ];

        $sql = "INSERT INTO user (user_email, user_password, user_name, user_role, user_status, user_address, user_bio, user_image_path, user_created_at) 
                VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }

        //bind dữ liệu theo câu lệnh insert ở trên
        $stmt->bind_param(
            "sssiissss", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
            $data['user_email'],
            $data['user_password'],
            $data['user_name'],
            $data['user_role'],
            $data['user_status'],
            $data['user_address'],
            $data['user_bio'],
            $data['user_image'], // Tên key 'user_image' được dùng ở đây
            $data['user_created_at']
        );
        //lưu vào biến để kiểm tra trạng thái
        $insert_success = $stmt->execute();

        if ($insert_success) {
            header("Location:?module=users_management&action=listUser&user_id=$user_id_current");
        } else {
            setSessionFlash('msg', 'Add new user failed');
            setSessionFlash('msg_type', 'danger');
        }
        $stmt->close();
    } else {
        setSessionFlash('msg', 'Invalid data, please check again');
        setSessionFlash('msg_type', 'danger');
        setSessionFlash('oldData', $filterArr);
        setSessionFlash('errors', $errors);
    }
} 

// Lấy dữ liệu cũ và lỗi (nếu có) sau khi xử lý POST
$oldData = getSessionFlash('oldData') ?? []; // Dùng ?? [] để đảm bảo là mảng
$errorsArr = getSessionFlash('errors') ?? [];
$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');


//header
$user_name = $data['user_name'];
$dataTitle = [
    'title' => "Add new user",
    'breadcrumb' => "List Users",
    'data' => $user_name,
    'module' => 'users_management',
    'action' => 'listUser'
];
layoutAdminUseInclude("header", $dataTitle);
?>

<?php layoutAdmin("sidebar"); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <?php layoutAdminUseInclude("breadcrumb", $dataTitle); ?>
    </div>
    <!--end::App Content Header-->
    
    <!--begin::App Content-->
    <div class="app-content container">
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container-fluid">
                <?php getMsg($msg, $msg_type); ?>
                
                <form action="" method="POST" enctype="multipart/form-data" class="p-4">
                    
                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_email" class="form-label fw-bold">Email address (<span class="text-danger">*</span>)</label>
                                <input type="text" name="user_email" class="form-control" id="user_email" placeholder="Enter email address" 
                                       value="<?php echo $oldData['user_email'] ?? ''; ?>" required>
                                <?php echo formErrors($errorsArr, 'user_email'); ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_password" class="form-label fw-bold">Password (<span class="text-danger">*</span>)</label>
                                <input type="password" name="user_password" class="form-control" id="user_password" placeholder="Enter password" required>
                                <?php echo formErrors($errorsArr, 'user_password'); ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_name" class="form-label fw-bold">Username (<span class="text-danger">*</span>)</label>
                                <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Enter username" 
                                       value="<?php echo $oldData['user_name'] ?? ''; ?>" required>
                                <?php echo formErrors($errorsArr, 'user_name'); ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_role" class="form-label fw-bold">Select role for user (<span class="text-danger">*</span>)</label>
                                <select class="form-select" name="user_role" id="user_role" required>
                                    <option value="0" <?php echo (isset($oldData['user_role']) && $oldData['user_role'] == '0') ? 'selected' : ''; ?>>User</option>
                                    <option value="1" <?php echo (isset($oldData['user_role']) && $oldData['user_role'] == '1') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                             <div class="mb-3">
                                <label for="user_status" class="form-label fw-bold">Select status for user (<span class="text-danger">*</span>)</label>
                                <select name="user_status" id="user_status" class="form-select" required>
                                    <option value="0" <?php echo (isset($oldData['user_status']) && $oldData['user_status'] == '0') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="1" <?php echo (isset($oldData['user_status']) && $oldData['user_status'] == '1') ? 'selected' : ''; ?>>Activated</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_address" class="form-label fw-bold">Address (<span class="text-danger">*</span>)</label>
                                <input name="user_address" id="user_address" type="text" class="form-control" placeholder="Enter address" 
                                       value="<?php echo $oldData['user_address'] ?? ''; ?>" required>
                                <?php echo formErrors($errorsArr, 'user_address'); ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="user_bio" class="form-label fw-bold">Bio</label>
                                <!-- Dữ liệu cũ cho CKEditor phải được đặt bên trong textarea -->
                                <textarea name="user_bio" id="user_bio" class="form-control" rows="5" placeholder="Enter bio"><?php echo $oldData['user_bio'] ?? ''; ?></textarea>
                                <script>
                                    CKEDITOR.replace('user_bio');
                                </script>
                            </div>
                        </div>

                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="formFileLg" class="form-label fw-bold">Upload a user image (<span class="text-danger">*</span>)</label>
                                <input name="user_image" class="form-control" id="formFileLg" type="file" required>
                                <?php echo formErrors($errorsArr, 'user_image'); ?>
                            </div>
                        </div>
                    </div> 

                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="?module=users_management&action=listUser&user_id=<?php echo $user_id_current; ?>" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Add user</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</main>
<?php layoutAdmin("footer"); ?>