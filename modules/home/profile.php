<?php
layoutUser('header');

$user_id;
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
                'user_address' => $filterArr['user_address'],
                'user_bio' => $save_content,
                'user_image' => $news_image_path,
            ];

            $sql = "UPDATE user 
                    SET    user_name=?,
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
                "ssss", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
                $data['user_name'],
                $data['user_address'],
                $data['user_bio'],
                $data['user_image'],
            );
            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
        } else {
            $data_without_image = [
                'user_name' => $filterArr['user_name'],
                'user_address' => $filterArr['user_address'],
                'user_bio' => $save_content,
            ];

            $sql = "UPDATE user 
                    SET    user_name=?,
                           user_address=?,
                           user_bio=?
                    WHERE  user_id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Loi prepare SQL: " . $conn->error);
            }

            //bind dữ liệu theo câu lệnh insert ở trên
            $stmt->bind_param(
                "sssi", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
                $data_without_image['user_name'],
                $data_without_image['user_address'],
                $data_without_image['user_bio'],
                $user_id
            );
            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
        }

        if ($insert_success) {
            header("Location:?module=home&action=index");
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
?>
<main>
    <div class="container">
        <div class="my-3 text-center fs-2 fw-bold">
            <span>Account Information</span>
        </div>
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container-fluid">
                <?php getMsg($msg, $msg_type); ?>
                <form action="" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="row g-3">
                        <div class="col-12 d-flex justify-content-center align-items-center flex-column">
                            <div class="rounded-circle bg-gray-200 overflow-hidden shadow-inner d-flex justify-content-center" style="width:200px;height:200px">
                                <!-- Ảnh xem trước -->
                                <img id="avatar-preview"
                                    src="<?= htmlspecialchars($data['user_image_path']); ?>"
                                    alt="Ảnh đại diện"
                                    class="w-full h-full object-cover rounded">
                            </div>
                            <label for="avatar-upload" class="btn btn-primary mt-3">Upload your image</label>
                            <input id="avatar-upload" type="file" accept="image/*" hidden name="user_image">
                        </div>


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
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Your username (<span class="text-danger">*</span>)</label>
                                <input type="text" name="user_name" class="form-control"
                                    id="exampleFormControlInput1" placeholder="Enter username" require value="<?= htmlspecialchars($data['user_name']) ?>">
                                <?php
                                echo formErrors($errorsArr, 'user_name');
                                ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label fw-bold">Your role </label>

                                <?php
                                if (htmlspecialchars($data['user_role']) == 1) {
                                    echo '<input type="text" name="user_role" class="form-control"
                                                      id="exampleFormControlInput1" value="Admin" disabled>';
                                    // echo '<option value="0">User</option>
                                    //       <option selected value="1">Admin</option>';
                                } else if (htmlspecialchars($data['user_role']) == 0) {
                                    echo '<input type="text" name="user_role" class="form-control"
                                                      id="exampleFormControlInput1" value="User" disabled>';
                                }

                                ?>
                            </div>
                        </div>
                        <div class="col-12">
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
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="?module=home&action=index" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</main>
<?php layoutUser('footer'); ?>