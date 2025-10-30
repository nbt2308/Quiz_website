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
        <link rel="stylesheet" href="./css/login.css" >
    </head>
    <body>
        <div class="login-container">
            <div class="title-login">
                <p>
                    SIGN IN
                </p>
            </div>
            <div class="login-form">
                <form action="login_xuly.php" method="POST">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">User name</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="User name">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Password</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Password">
                    </div>
                    <div class="forgot-password">
                        <a href="forgotPassword.php">Forgot your password?</a>
                    </div>
                    <div class="btn-signin">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                    <div class="register">
                        <p>Don't have an account?</p>
                        <a href="register.php">Create a new account</a>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>