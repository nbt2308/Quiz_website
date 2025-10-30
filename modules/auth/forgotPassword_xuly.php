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
    <link rel="stylesheet" href="./css/forgotPassword.css">
</head>
<body>
    <form action="" method="post">
        <div class="forgot-password-title">
            <span>FORGOT PASSWORD</span>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="password">
            <label for="floatingInput">New password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="password">
            <label for="floatingInput">Confirm password</label>
        </div>
    </form>
</body>
</html>