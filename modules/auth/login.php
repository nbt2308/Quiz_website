<?php

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
    //validate password
    if (empty(trim($filterArr['password']))) {
        $errors['password']['required'] = "Password is required";
    } else {
        if (strlen(trim($filterArr['password'])) < 6) {
            $errors['password']['length'] = "Password must be 6 characters long";
        }
    }
    if (empty($errors)) {
        //
        $email = $filterArr['email'];
        $password = $filterArr['password'];

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
            //kiểm tra mật khẩu có hợp lệ không
            if (!empty($password)) {

                $checkPass = false;
                if (strcmp(md5($password), $user['user_password']) === 0) {
                    $checkPass = true;
                }
                if ($checkPass) {
                    //Kiểm tra xem tài khoản đã được kích hoạt hay chưa
                    if ($user['user_status'] == 1) {
                        //Tạo session khi đăng nhập thành công
                        setSesstion("logged_in", "you are logged in");
                        setSesstion("user_id", $user['user_id']);
                        setSesstion("user_name", $user['user_name']);
                        setSesstion("user_role", $user['user_role']);
                        setSesstionFlash('msg', 'Login succeed');
                        setSesstionFlash('msg_type', 'success');
                        header("Location:?module=home&action=index");
                    } else {
                        setSesstionFlash('msg', 'Please check your email to activate your account and login again');
                        setSesstionFlash('msg_type', 'danger');
                    }
                } else {
                    setSesstionFlash('msg', 'Invalid Email or Password');
                    setSesstionFlash('msg_type', 'danger');
                }
            }
        }
    } else {
        setSesstionFlash('msg', 'Invalid data, please check again');
        setSesstionFlash('msg_type', 'danger');
        setSesstionFlash('oldData', $filterArr);
        setSesstionFlash('errors', $errors);
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/auth/login.css">
    <title>Sign in</title>
</head>

<body>
    <div class="login-container">
        <div>
            <img src="/News_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div>
            <?php getMsg($msg, $msg_type); ?>
            <div class="login-content">
                <div class="title-login mb-3 mt-3">
                    <span>
                        SIGN IN
                    </span>
                </div>
                <div class="login-form mt-3">
                    <form action="" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php echo showOldData($oldData, 'email'); ?>">
                            <label for="floatingInput">Email address</label>
                            <?php
                            echo formErrors($errorsArr, 'email');
                            ?>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                            <?php
                            echo formErrors($errorsArr, 'password');
                            ?>
                        </div>
                        <div class="forgot-password mt-3">
                            <a href="?module=auth&action=forgotPassword">Forgot your password?</a>
                        </div>
                        <div class="btn-login">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>
                        <div class="register mb-3">
                            <span>Don't have an account?</span>
                            <a href="?module=auth&action=register">Create a new account</a>
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