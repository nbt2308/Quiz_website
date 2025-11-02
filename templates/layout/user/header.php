<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/news/manageNews.css">
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/home/style.css">
    <title>TH News Website</title>
</head>

<body>
    <header>
        <div class="header container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand logo-brand" href="?module=home&action=index"><img src="/Quiz_website/templates/assets/images/TH.png" alt="Logo-brand"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="?module=home&action=index">Home</a>
                            </li>
                            <!-- check role -->
                            <li class="nav-item">
                                <a class="nav-link" href="?module=news&action=manageNews">Manage</a>
                            </li>


                            <li class="nav-item datetime">
                                <?php echo '<a class="nav-link" disabled>' . date('d/m/Y ') . '</a>'; ?>
                            </li>




                        </ul>
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                        <!-- <form method="get" class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <input type="hidden" name="module" value="home">
                        <input type="hidden" name="action" value="index">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form> -->
                        <?php
                        //Check người dùng đã đăng nhập hay chưa
                        $Login = getSession("user_id");
                        if (!isset($Login)) {
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
                                        Setting
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><a class="dropdown-item" href="#">Logout</a></li>
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