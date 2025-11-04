<?php
// if(!defined('_USER')){
//     die("Truy cập không hợp lệ") ;
// }
$logged_in = getSession("logged_in");
if ($logged_in) {
    require_once './modules/errors/logged_in.php';
    die();
}

if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];
    //validate email
    if (empty(trim($filterArr['email']))) {
        $errors['email']['required'] = "Email is required";
    } else {
        //correct format
        if (!validateEmail(trim($filterArr['email']))) {
            $errors['email']['isEmail'] = "Email is invalid";
        }
    }

    if (empty($errors)) {
        $email = $filterArr['email'];

        //kiểm tra email có hợp lệ không
        $sql = "SELECT * FROM user WHERE user_email = ?";

        //Chuẩn bị
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }
        //Gán biến (Bind)
        // "s" có nghĩa là biến $token là kiểu String
        $stmt->bind_param("s", $email);

        //Thực thi
        $stmt->execute();

        //Lấy kết quả
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // Lấy 1 hàng

        // Đóng
        $stmt->close();

        if (!empty($user)) {
            //update forgot token vào db 
            $forgot_password_token = sha1(uniqid() . time());
            $data = [
                'user_email' => $user['user_email'],
                'user_forget_token' => $forgot_password_token,
                'user_id' => $user['user_id']
            ];
            //kiểm tra email có hợp lệ không
            $sql = "UPDATE user 
                    SET    user_forget_token=?
                    WHERE  user_id = ?";

            //Chuẩn bị
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Loi prepare SQL: " . $conn->error);
            }
            //Gán biến (Bind)
            // "s" có nghĩa là biến $token là kiểu String
            $stmt->bind_param(
                "ss",
                $data['user_forget_token'],
                $data['user_id']
            );

            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
            if ($insert_success) {
                //gửi mail đổi mật khẩu cho người dùng
                $emailTo = $data['user_email'];
                $subjectEmail = "Chào mừng bạn đến với TH News! Đây là đường link liên kết đổi mật khẩu của bạn.";
                $contentEmail = "Link tại đây </br>";
                $contentEmail .= _HOST_URL . '/?module=auth&action=resetPassword&token=' . $forgot_password_token . '</br>';
                $contentEmail .= 'Cảm ơn bạn đã ủng hộ TH News';
                sendMail($emailTo, $subjectEmail, $contentEmail);

                setSesstionFlash('msg', 'Confirmed successfully, please check your email');
                setSesstionFlash('msg_type', 'success');
                $last_id = $conn->insert_id;
            } else {
                setSesstionFlash('msg', 'Confirmed failure');
                setSesstionFlash('msg_type', 'danger');
            }
            $stmt->close();
        }
    } else {
        setSesstionFlash('msg', 'Invalid data, please check again');
        setSesstionFlash('msg_type', 'danger');
        setSesstionFlash('errors', $errors);
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/auth/forgotPassword.css">
    <title>Forgot password</title>
</head>

<body>
    <div class="forgotPassword-container">
        <div class="logo-brand mb-4">
            <img src="/News_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div>
            <?php getMsg($msg, $msg_type); ?>
            <div class="forgotPassword-content">
                <div class="forgotPassword-title mb-3 mt-3">
                    <span>FORGOT PASSWORD</span>
                </div>
                <div class="form-forgotPassword mt-3">
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                            <?php
                            echo formErrors($errorsArr, 'email');
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