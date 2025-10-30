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
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/changePassword.css">
</head>
<body>
    <form action="" method="POST">
        <div class="change-password-title">
            <span>CHANGE PASSWORD</span>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="current password">
            <label for="floatingInput">Current password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="new password">
            <label for="floatingInput">New password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="confirm password">
            <label for="floatingInput">Confirm password</label>
        </div>
        <div class="change-button">
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
    </form>
</body>
</html>