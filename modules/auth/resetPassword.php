<?php

$logged_in = getSession("logged_in");
if ($logged_in) {
    require_once './modules/errors/logged_in.php';
    die();
}

$filterGet = filterData('GET');
if (!empty($filterGet['token'])) {
    $token_reset = $filterGet['token'];
}
if (!empty($token_reset)) {

    $sql = "SELECT * FROM user WHERE user_forget_token = ?";

    //Chuẩn bị
    $stmt = $conn->prepare($sql);

    //Gán biến (Bind)
    // "s" có nghĩa là biến $token là kiểu String
    $stmt->bind_param("s", $token_reset);

    //Thực thi
    $stmt->execute();

    //Lấy kết quả
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Lấy 1 hàng

    // Đóng
    $stmt->close();

    if (!empty($user)) {
        if (isMethodPost()) {
            $filterArr = filterData();
            $errors = [];
            //validate password
            if (empty(trim($filterArr['new_password']))) {
                $errors['new_password']['required'] = "New password is required";
            } else {
                if (strlen(trim($filterArr['new_password'])) < 6) {
                    $errors['new_password']['length'] = "Password must be 6 characters long";
                }
            }
            //validate confirm password
            if (empty(trim($filterArr['confirmPassword']))) {
                $errors['confirmPassword']['required'] = "Please re-enter password";
            } else {
                if (trim($filterArr['confirmPassword']) !== trim($filterArr['new_password'])) {
                    $errors['confirmPassword']['like'] = "Confirm password does not match";
                }
            }

            if (empty($errors)) {
                $new_password = md5($filterArr['new_password']);
                $data = [
                    'new_password' => $new_password,
                    'user_forget_token' => null,
                    'user_id' => $user['user_id']
                ];
                //kiểm tra email có hợp lệ không
                $sql = "UPDATE user 
                        SET    user_forget_token=?,
                               user_password=?
                        WHERE  user_id = ?";

                //Chuẩn bị
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Loi prepare SQL: " . $conn->error);
                }
                //Gán biến (Bind)
                // "s" có nghĩa là biến $token là kiểu String
                $stmt->bind_param(
                    "ssi",
                    $data['user_forget_token'],
                    $data['new_password'],
                    $data['user_id']
                );

                //lưu vào biến để kiểm tra trạng thái
                $update_success = $stmt->execute();
                if ($update_success) {
                    //gửi mail đổi mật khẩu thành công cho tài khoản cho người dùng
                    $emailTo = $user['user_email'];
                    $subjectEmail = "Xin Chào " . $user['user_name'] . ", Bạn vừa thay đổi mật khẩu tài khoản của mình thành công.";
                    $contentEmail .= 'Cảm ơn bạn ủng hộ TH News';
                    sendMail($emailTo, $subjectEmail, $contentEmail);


                    setSessionFlash('msg', 'Reset password succeed');
                    setSessionFlash('msg_type', 'success');
                    header("Location:?module=auth&action=login");
                }
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
    } else {
        require_once './modules/errors/linkExpired.php';
        die();
    }
} else {
    require_once './modules/errors/linkExpired.php';
    die();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/auth/resetPassword.css">
    <title>Reset password</title>
</head>

<body>
    <div class="resetPassword-container">
        <div class="logo-brand mb-4">
            <img src="/News_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div class="frame-resetPassword">
            <?php getMsg($msg, $msg_type); ?>
            <div class="resetPassword-content">
                <div class="resetPassword-title mb-3 mt-3">
                    <span>RESET PASSWORD</span>
                </div>
                <div class="form-resetPassword mt-3">
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="password" name="new_password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">New password</label>
                            <?php
                            echo formErrors($errorsArr, 'new_password');
                            ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="confirmPassword" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Confirm password</label>
                            <?php
                            echo formErrors($errorsArr, 'confirmPassword');
                            ?>
                        </div>
                        <div class="btn-confirm mb-3">
                            <button type="submit">Confirm</button>
                        </div>
                    </form>
                    <div class="btn-goBack btn mb-4"><a href="?module=home&action=index">Go to homepage</a></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    layoutUser("footer");
    ?>