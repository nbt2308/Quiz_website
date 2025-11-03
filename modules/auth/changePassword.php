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
    <link rel="stylesheet" href="/News_website/modules/auth/css/css/changePassword.css">
</head>

<body>
    <div class="changePassword-container">
        <div class="logo-brand">
            <img src="News_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div class="changePassword-content">
            <form action="" method="POST" class="m-5">
                <div class="change-password-title">
                    <span>Change Password</span>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Current password</label>
                </div>
                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">New password</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Confirm password</label>
                </div>
                <div class="change-button mt-3">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
                <div class="btn-goBack btn"><span>Go to homepage</span></div>

            </form>
        </div>
    </div>
</body>

</html>