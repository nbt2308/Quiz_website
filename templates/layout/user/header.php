<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/news/manageNews.css">
    <link rel="stylesheet" href="/News_website/templates/assets/css/home/style.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <title>TH News Website</title>
</head>

<body>
    <header>
        <div class="header container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand logo-brand" href="?module=home&action=index"><img src="/News_website/templates/assets/images/TH.png" alt="Logo-brand"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link homePage <?php echo $_GET['action'] == "index" ? "active" : "" ?>" aria-current="page" href="?module=home&action=index">Home</a>
                            </li>
                            <!-- check role -->
                            <li class="nav-item mx-2">
                                <?php
                                    $user_id = getSession("user_id");
                                ?>
                                <a class="nav-link managePage <?php echo $_GET['action'] == "manageNews" ? "active" : "" ?>" href="?module=news&action=manageNews&user_id=<?php echo $user_id ?>">Manage</a>
                            </li>
                            <?php
                            $Admin = getSession('user_role');
                            if ($Admin == 1) {
                                $user_id = getSession("user_id");
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link adminPage" href="?module=admin&action=index&user_id=<?php echo $user_id ?>">Admin</a>
                                </li>
                            <?php
                            }
                            ?>

                            <li class="nav-item mx-2">
                                <a class="nav-link aboutUsPage <?php echo $_GET['action'] == "aboutUs" ? "active" : "" ?>" href="?module=home&action=aboutUs">About Us</a>
                            </li>

                            <li class="nav-item datetime mt-2 ms-3">
                                <?php echo '<a class="text-secondary text-decoration-none" disabled>' . date('d/m/Y ') . '</a>'; ?>
                            </li>




                        </ul>
                        <!-- <form method="get" class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <input type="hidden" name="module" value="home">
                        <input type="hidden" name="action" value="index">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form> -->
                        <?php
                        //Check người dùng đã đăng nhập hay chưa
                        $Login = getSession("logged_in");
                        if (!$Login) {
                        ?>
                            <div class="signin-signup ms-3">
                                <a href="?module=auth&action=login" class="btn-login">Sign in</a>
                                <a href="?module=auth&action=register" class="btn-register">Sign up</a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <ul class="list-unstyled ms-4 mt-3">
                                <li class="nav-item dropdown ">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="/News_website/templates/assets/images/settings_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="Setting">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><a class="dropdown-item" href="?module=auth&action=logout">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
    </header>