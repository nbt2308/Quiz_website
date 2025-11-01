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
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/auth/register.css">
    <title>Sign up</title>
</head>

<body>
    <div class="register-container">
        <div class="logo-brand mb-4">
            <img src="/Quiz_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div class="register-content">
            <div class="register-title mb-3 mt-3">
                <span>SIGN UP</span>
            </div>
            <div class="form-register mt-3">
                <form action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Password</label>
                    </div>
                    <div class="btn-register">
                        <button onclick="">Sign up</button>
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
    <?php
    layoutUser("footer");
    ?>