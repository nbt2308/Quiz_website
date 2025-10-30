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
        <div class="logo-brand">

        </div>
        <div class="register-container">
            <div class="register-content">
                <div class="register-title">
                    <span>Create a new account</span>
                </div>
                <div class="form-register mt-3">
                    <form class="form-floating">
                        <input type="email" class="form-control" id="floatingInputValue" placeholder="name@example.com" value="">
                        <label for="floatingInputValue">Email</label>
                    </form>
                    <form class="form-floating my-3">
                        <input type="email" class="form-control" id="floatingInputValue" placeholder="name@example.com" value="">
                        <label for="floatingInputValue">Username</label>
                    </form>
                    <form class="form-floating">
                        <input type="email" class="form-control" id="floatingInputValue" placeholder="name@example.com" value="">
                        <label for="floatingInputValue">Password</label>
                    </form>
                    <div class="btn-register">
                        <button>SIGN UP</button>
                    </div>
                    <div className="sign-in">
                        <span>Already have an account</span>
                        <span className="btn-signin">Sign in</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>