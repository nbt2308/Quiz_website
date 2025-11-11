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
        
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
                <div class="container">
                    <!-- Logo -->
                    <a class="navbar-brand d-flex align-items-center" href="?module=home&action=index">
                        <img src="/News_website/templates/assets/images/TH.png" alt="Logo" style="height:50px;">
                        <span class="fw-bold fs-6 ms-2 text-primary">TH News</span>
                    </a>

                    <!-- Toggler mobile -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Nav links + user -->
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                            <li class="nav-item mx-lg-2 text-center">
                                <a class="nav-link <?= ($_GET['action'] == "index") ? "active fw-bold fs-6" : "fs-6" ?>" href="?module=home&action=index">Home</a>
                            </li>

                            <?php $user_id = getSession("user_id"); ?>
                            <li class="nav-item mx-lg-2 text-center">
                                <a class="nav-link <?= ($_GET['action'] == "manageNews") ? "active fw-bold fs-6" : "fs-6" ?>" href="?module=news&action=manageNews&user_id=<?= $user_id ?>">Manage</a>
                            </li>

                            <?php if (getSession('user_role') == 1): ?>
                                <li class="nav-item mx-lg-2 text-center">
                                    <a class="nav-link fs-6" href="?module=admin&action=index&user_id=<?= $user_id ?>">Admin</a>
                                </li>
                            <?php endif; ?>

                            <li class="nav-item mx-lg-2 text-center">
                                <a class="nav-link <?= ($_GET['action'] == "aboutUs") ? "active fw-bold fs-6" : "fs-6" ?>" href="?module=home&action=aboutUs">About Us</a>
                            </li>

                            <li class="nav-item datetime mx-lg-2 text-center">
                                <?php echo '<a class="text-secondary text-decoration-none" disabled>' . date('d/m/Y ') . '</a>'; ?>
                            </li>
                        </ul>

                        <!-- User / Sign in -->
                        <?php if (!getSession("logged_in")): ?>
                            <div class="d-flex gap-2">
                                <a href="?module=auth&action=login" class="btn btn-outline-primary btn-md">Sign In</a>
                                <a href="?module=auth&action=register" class="btn btn-primary btn-md">Sign Up</a>
                            </div>
                        <?php else: ?>
                            <ul class="navbar-nav ms-lg-3">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center fs-6" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="/News_website/templates/assets/images/settings_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="User" class="rounded-circle" style="width:24px;height:24px;">
                                        <span class="ms-2"><?= htmlspecialchars(getSession("user_name")) ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item fs-6" href="#">Profile</a></li>
                                        <li><a class="dropdown-item fs-6" href="?module=auth&action=logout">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        
    </header>