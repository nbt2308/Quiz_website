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


    //validate current password
    if (empty(trim($filterArr['user_password']))) {
        $errors['user_password']['required'] = "Current password is required";
    } else {
        $user_password = $filterArr['user_password'];
        $checkUserPassword = strcmp(md5($user_password), $data['user_password']);
        if ($checkUserPassword !== 0) {
            $errors['user_password']['invalid'] = "Current password is invalid";
        }
    }
    //validate new password
    if (empty(trim($filterArr['new_password']))) {
        $errors['new_password']['required'] = "New password is required";
    } else {
        if (strlen(trim($filterArr['new_password'])) < 6) {
            $errors['new_password']['length'] = "Password must be 6 characters long";
        } else {
            if (trim($filterArr['new_password']) === trim($filterArr['user_password'])) {
                $errors['new_password']['like'] = "New password cannot be the same as current password";
            }
        }
    }
    //validate confirm password
    if (empty(trim($filterArr['confirm_new_password']))) {
        $errors['confirm_new_password']['required'] = "Please re-enter password";
    } else {
        if (trim($filterArr['confirm_new_password']) !== trim($filterArr['new_password'])) {
            $errors['confirm_new_password']['like'] = "Confirm password does not match";
        }
    }

    if (empty($errors)) {
        //not found error

        $data = [
            'new_password' => md5($filterArr['new_password']),
            'user_id' => $user_id
        ];

        $sql = "UPDATE user 
                SET    user_password=?
                WHERE  user_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }

        //bind dữ liệu theo câu lệnh insert ở trên
        $stmt->bind_param(
            "si", //định dạng kiểu dữ liệu theo đúng thứ tự: string
            $data['new_password'],
            $data['user_id'],
        );
        //lưu vào biến để kiểm tra trạng thái
        $insert_success = $stmt->execute();

        if ($insert_success) {
            setSessionFlash('msg', 'Change password succeed');
            setSessionFlash('msg_type', 'success');
            $last_id = $conn->insert_id;
        } else {
            setSessionFlash('msg', 'Change password failed');
            setSessionFlash('msg_type', 'danger');
        }
        $stmt->close();
    } else {
        setSessionFlash('msg', 'Invalid data, please check again');
        setSessionFlash('msg_type', 'danger');
        setSessionFlash('errors', $errors);
    }

    $errorsArr = getSessionFlash('errors');
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
} else {
    $msg = "";
    $msg_type = '';
    $errorsArr = "";
}
?>
<style>
    .box-small {
        max-width: 620px;
        margin: 0 auto;
    }
</style>
<main>
    <div class="container">
        <div class="my-3 text-center fs-2 fw-bold">
            <span>Change password</span>
        </div>


        <div class="box-small shadow p-3 mb-5 bg-body rounded">

            <?php getMsg($msg, $msg_type); ?>

            <form action="" method="POST" class="mt-3">

                <!-- Current Password -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Current password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="user_password"
                            class="form-control password-field"
                            id="current_password"
                            placeholder="Enter current password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">👁</button>
                    </div>
                    <?= formErrors($errorsArr, 'user_password'); ?>
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label class="form-label fw-bold">New password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="new_password"
                            class="form-control password-field"
                            id="new_password"
                            placeholder="Enter new password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">👁 </button>
                    </div>
                    <?= formErrors($errorsArr, 'new_password'); ?>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Confirm new password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="confirm_new_password"
                            class="form-control password-field"
                            id="confirm_password"
                            placeholder="Re-enter new password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">👁</button>
                    </div>
                    <?= formErrors($errorsArr, 'confirm_new_password'); ?>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="?module=home&action=index" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</main>
<?php layoutUser('footer'); ?>