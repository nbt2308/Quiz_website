<?php 
    // if(!defined('_USER')){
    //     die("Truy cập không hợp lệ") ;
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Quiz_website/modules/auth/css/css/forgotPassword.css">
</head>
<body>
    <form action="forgotPassword_xuly.php" method="post">
        <div class="forgot-password-title">
            <span>FORGOT PASSWORD</span>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="confirm-button">
            <button type="submit" class="btn btn-primary">Confirm email</button>
        </div>
        <?php ?>
    </form>
</body>
</html>