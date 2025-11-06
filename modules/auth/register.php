<?php
$logged_in = getSession("logged_in");
if ($logged_in) {
    require_once './modules/errors/logged_in.php';
    die();
}
//test function filterData
// if (!empty($_POST)) {
//     $filterArr = filterData('post');
//     echo '<pre>';
//     print_r($filterArr);
//     echo '</pre>';
//     die();
// }

//validate data
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];

    //validate username
    if (empty(trim($filterArr['username']))) {
        $errors['username']['required'] = "Username is required";
    } else {
        if (strlen(trim($filterArr['username'])) < 5) {
            $errors['username']['length'] = "Username must be 5 characters long";
        }
    }
    //validate email
    if (empty(trim($filterArr['email']))) {
        $errors['email']['required'] = "Email is required";
    } else {
        //correct format
        if (!validateEmail(trim($filterArr['email']))) {
            $errors['email']['isEmail'] = "Email is invalid";
        }
        //Email already exists in db
        else {
            $email = $filterArr['email'];
            $sql = "SELECT COUNT(*) AS total FROM user WHERE user_email='$email'";
            $result = $conn->query($sql);
            $checkMail = $result->fetch_assoc()['total'];
            if ($checkMail > 0) {
                $errors['email']['exist'] = "Email already exists";
            }
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
    //validate confirm password
    if (empty(trim($filterArr['confirmPassword']))) {
        $errors['confirmPassword']['required'] = "Please re-enter password";
    } else {
        if (trim($filterArr['confirmPassword']) !== trim($filterArr['password'])) {
            $errors['confirmPassword']['like'] = "Confirm password does not match";
        }
    }

    if (empty($errors)) {
        //not found error
        $active_token = sha1(uniqid() . time());
        $data = [
            'user_email' => $filterArr['email'],
            'user_name' => $filterArr['username'],
            'user_password' => md5($filterArr['password']),
            'user_active_token' => $active_token,
            'user_role' => FALSE,
            'user_created_at' => date('Y-m-d H:i:s')
        ];

        $sql = "INSERT INTO user (user_email, user_password, user_name, user_role, user_active_token, user_created_at) 
                VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Loi prepare SQL: " . $conn->error);
        }
        //chuyển role từ False qua int: 0
        $role_int = (int)$data['user_role'];
        //bind dữ liệu theo câu lệnh insert ở trên
        $stmt->bind_param(
            "sssiss", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
            $data['user_email'],
            $data['user_password'],
            $data['user_name'],
            $role_int,
            $data['user_active_token'],
            $data['user_created_at']
        );
        //lưu vào biến để kiểm tra trạng thái
        $insert_success = $stmt->execute();

        if ($insert_success) {
            //gửi mail kích hoạt tài khoản cho người dùng
            $emailTo = $data['user_email'];
            $subjectEmail = "Chào mừng bạn đến với TH News! Kích hoạt tài khoản ngay.";
            $contentEmail = "Link kích hoạt tại đây: </br>";
            $contentEmail .= 'http://localhost/News_website/?module=auth&action=active&token=' . $active_token . '</br>';
            $contentEmail .= ' Cảm ơn bạn đã đăng ký tài khoản tại TH News';
            sendMail($emailTo, $subjectEmail, $contentEmail);


            setSessionFlash('msg', 'Register succeed, please check your email to activate your account');
            setSessionFlash('msg_type', 'success');
            $last_id = $conn->insert_id;
        } else {
            setSessionFlash('msg', 'Register failed');
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/auth/register.css">
    <title>Sign up</title>
</head>

<body>

    <div class="register-container">
        <div class="logo-brand mb-4">
            <img src="/News_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div class="frame-register">
            <?php getMsg($msg, $msg_type); ?>
            <div class="register-content">

                <div class="register-title mb-3 mt-3">
                    <span>SIGN UP</span>
                </div>
                <div class="register-form mt-3">
                    <form action="" method="POST" class="mb-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php echo showOldData($oldData, 'email'); ?>">
                            <label for="floatingInput">Email address</label>
                            <?php
                            echo formErrors($errorsArr, 'email');
                            ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo showOldData($oldData, 'username'); ?>">
                            <label for="floatingInput">Username</label>
                            <?php
                            echo formErrors($errorsArr, 'username');
                            ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingInput" placeholder="name@example.com" name="password" value="<?php echo showOldData($oldData, 'password'); ?>">
                            <label for="floatingInput">Password</label>
                            <?php
                            echo formErrors($errorsArr, 'password');
                            ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingInput" placeholder="name@example.com" name="confirmPassword">
                            <label for="floatingInput">Confirm password</label>
                            <?php
                            echo formErrors($errorsArr, 'confirmPassword');
                            ?>
                        </div>
                        <div class="btn-register">
                            <button type="submit">Sign up</button>
                        </div>
                    </form>
                    <div class="sign-in mb-3">
                        <span>Already have an account?</span>
                        <a href="?module=auth&action=login">Sign in</a>
                    </div>
                    <div class="btn-goBack btn mb-4"><a href="?module=home&action=index">Go to homepage</a></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    layoutUser("footer");
    ?>