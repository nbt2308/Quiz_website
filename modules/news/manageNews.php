<?php 
    include_once 'addNews.php';
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add News</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./css/addNews.css">
        <link rel="stylesheet" href="../../templates/assets/css/home/style.css">
    </head>
    <body>
        <div cl ass="header container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand logo-brand"   href="#"><img src="/Quiz_website/templates/assets/images/TH.png" alt="Logo-brand"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                         <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Post</a>
                        </li>
                        <!-- check role -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">Manage</a>
                        </li>

                       

                        <!-- check login  -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Setting
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>

                        <!-- lay ngay thang bang js -->
                         <li class="nav-item datetime">
                            <a class="nav-link disabled" href="#">ngaythang</a>
                        </li>




                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <?php   ?>
                    <div class="signin-signup ms-3">
                         <form method="POST">
                            <button type="submit" name="signIn" class="btn btn-primary">Sign in</button>
                            <button type="submit" name="signUp" class="btn btn-primary">Sign up</button>
                        </form>
                       
                    </div>
                </div>
            </div>
        </nav>
    </div>
        <div class="addNews-container container">
            <div class="addNews-content ">
                <div class="addNews-title my-3">
                    <span>Post News</span>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddNews">
                    Launch static backdrop modal
                </button>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>