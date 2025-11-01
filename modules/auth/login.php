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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/auth/login.css">
    <title>Sign in</title>
</head>

<body>
    <div class="login-container">
        <div>
            <img src="/Quiz_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div class="login-content">
            <div class="title-login mb-3 mt-3">
                <span>
                    SIGN IN
                </span>
            </div>
            <div class="login-form mt-3">
                <form action="" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
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
    <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            Copyright © 2025. All rights reserved.
        </div>
        <!-- Copyright -->

        <!-- Right -->
        <div class="text-white mb-3 mb-md-0">
            TH News Website
        </div>
        <!-- Right -->
    </div>

</body>

</html>