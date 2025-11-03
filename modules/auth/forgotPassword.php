<?php
// if(!defined('_USER')){
//     die("Truy cập không hợp lệ") ;
// }
$logged_in = getSession("logged_in");
if ($logged_in) {
    require_once './modules/errors/logged_in.php';
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/auth/forgotPassword.css">
    <title>Sign up</title>
</head>

<body>
    <div class="forgotPassword-container">
        <div class="logo-brand mb-4">
            <img src="/News_website/templates/assets/images/TH.png" alt="Logo-brand">
        </div>
        <div class="forgotPassword-content">
            <div class="forgotPassword-title mb-3 mt-3">
                <span>FORGOT PASSWORD</span>
            </div>
            <div class="form-forgotPassword mt-3">
                <form action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="btn-confirm mb-3">
                        <button onclick="">Confirm</button>
                    </div>
                </form>
                <div class="btn-goBack btn mb-4"><a href="?module=home&action=index">Go to homepage</a></div>
            </div>
        </div>
    </div>
    <?php
    layoutUser("footer");
    ?>