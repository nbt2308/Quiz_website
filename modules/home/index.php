<?php
// if(!defined('_USER')){
//     die("Truy cập không hợp lệ") ;
// }

// function redirect($url)
// {
//     if (!headers_sent()) {
//         header("Location: $url");
//         exit();
//     } else {
//         echo "<script>window.location.href='$url';</script>";
//         exit();
//     }
// }
// if (isset($_POST['signIn'])) {
//     redirect('modules/auth/login.php');
// }
// if (isset($_POST['signUp'])) {
//     redirect('modules/auth/register.php');
// }
$sql = "SELECT name FROM category";
$result = $conn->query($sql);
//home
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/home/style.css">
    <title>Home</title>
</head>

<body>
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
                    <!-- <form method="get" class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <input type="hidden" name="module" value="home">
                        <input type="hidden" name="action" value="index">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form> -->
                    <?php   ?>
                    <div class="signin-signup ms-3">
                        <a href="?module=auth&action=login" class="btn-login">Sign in</a>
                        <a href="?module=auth&action=register" class="btn-register">Sign up</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="category container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="category-title">
                        <a href="#"><strong>' . htmlspecialchars($row['name']) . '</strong></a>
                    </div>
        ';
            }
        } else {
            echo "<p>Không có dữ liệu.</p>";
        }
        ?>
        <!-- <div class="category-title"><a href="#"><strong>Breaking news</strong></a></div>
        <div class="category-title"><a href="#"><strong>World</strong></a></div>
        <div class="category-title"><a href="#"><strong>Business</strong></a></div>
        <div class="category-title"><a href="#"><strong>Sports</strong></a></div>
        <div class="category-title"><a href="#"><strong>Technology</strong></a></div>
        <div class="category-title"><a href="#"><strong>Health</strong></a></div>
        <div class="category-title"><a href="#"><strong>Entertainment</strong></a></div>
        <div class="category-title"><a href="#"><strong>Law</strong></a></div>
        <div class="category-title"><a href="#"><strong>Education</strong></a></div>
        <div class="category-title"><a href="#"><strong>Lifestyle</strong></a></div> -->
    </div>
    <div class="main container">
        <div class="left-container ">
            <span class="category-title">Breaking news</span>
            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="d-flex align-items-center justify-content-center p-3">
                            <img src="https://picsum.photos/400/250?random=1" class="rounded me-3" alt="ảnh 1" style="width:400px;height:250px;object-fit:cover;">
                            <div>
                                <h5 class="fw-bold">50+ hình nền phong cảnh thiên nhiên, 3D cực đẹp, full HD</h5>
                                <p class="text-muted mb-0">
                                    Ngày nay phần lớn mọi người ai cũng có sở hữu cho bản thân một chiếc điện thoại thông minh.
                                    Việc tìm kiếm hình nền phong cảnh thiên nhiên tươi mới dường như là một sở thích của nhiều người.
                                </p>
                                <p class="mt-5">Ngày đăng: 30-10-2025</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="d-flex align-items-center justify-content-center p-3">
                            <img src="https://picsum.photos/400/250?random=2" class="rounded me-3" alt="ảnh 2" style="width:400px;height:250px;object-fit:cover;">
                            <div>
                                <h5 class="fw-bold">Bộ sưu tập hình nền thành phố về đêm tuyệt đẹp</h5>
                                <p class="text-muted mb-0">
                                    Ánh đèn lung linh và bầu trời đêm tĩnh lặng tạo nên khung cảnh tuyệt đẹp khiến nhiều người say mê.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <div class="d-flex align-items-center justify-content-center p-3">
                            <img src="/Quiz_website/templates/assets/images/logo.png" class="rounded me-3" alt="ảnh 3" style="width:400px;height:250px;object-fit:cover;">
                            <div>
                                <h5 class="fw-bold">Những hình nền phong cảnh biển xanh mát mắt</h5>
                                <p class="text-muted mb-0">
                                    Hình ảnh đại dương bao la, sóng vỗ rì rào mang lại cảm giác bình yên và thư giãn tuyệt đối.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Nút điều hướng -->
                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>

                <!-- Chấm nhỏ bên dưới -->
                <div class="carousel-indicators mt-3">
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="2"></button>
                </div>
            </div>
            <div class="card">
                <div class="image-preview">
                    <img class="card-img-top" src="/Quiz_website/templates/assets/images/logo1.png" alt="Card-image-cap" />
                </div>
                <div class="card-body">
                    <h5 class="card-title">Tieu de</h5>
                    <div class="text-limit"><p class="card-text"></p></div>
                    <button class="btn btn-primary">View more</button>
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
    <div class="footer container">

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>