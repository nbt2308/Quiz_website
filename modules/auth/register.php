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
    <link rel="stylesheet" href="./css/register.css">
    <title>Document</title>
</head>

<body>
    <div class="register-main">
        <div class="logo-brand mb-4">
            <img src="../../templates//assets//images//TH.png" alt="Logo-brand">
        </div>
        <div class="register-container">
            <div class="register-content">
                <div class="register-title mb-3 mt-3">
                    <span>Create a new account</span>
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
                            <button onclick="">SIGN UP</button>
                        </div>
                    </form>
                    <div class="sign-in mb-3">
                        <span>Already have an account?</span>
                        <a href="login.php">Sign in</a>
                    </div>
                    <div class="btn-goBack btn"><span>Go to homepage</span></div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>