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
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-content">
            <div class="title-login">
                <span>
                    SIGN IN
                </span>
            </div>
            <div class="login-form">
                <form action="login_xuly.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="forgot-password">
                        <a href="register.php">Forgot your password</a>
                    </div>
                    <div class="btn-login">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                    <div class="register">
                        <span>Don't have an account?</span>
                        <a href="register.php">Create a new account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>