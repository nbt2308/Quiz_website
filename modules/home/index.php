<?php
// if(!defined('_USER')){
//     die("Truy cập không hợp lệ") ;
// }


//lấy tất cả tên chủ đề






//home
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\Quiz_website\templates\assets\css\home\style.css">
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
        $sql = "SELECT name FROM category";
        $result = $conn->query($sql);
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


            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                    $sql2 = "SELECT n.*, c.name AS category_name
                            FROM news n
                            JOIN category c ON n.category_id = c.category_id
                            JOIN (
                                SELECT category_id, MAX(post_date) AS latest_post
                                FROM news
                                GROUP BY category_id
                            ) vmax ON n.category_id = vmax.category_id AND n.post_date = vmax.latest_post;
";

                    $result = $conn->query($sql2);
                    if ($result->num_rows > 0) {
                        $isActive = true;
                        while ($row = $result->fetch_assoc()) {
                            echo '
                    <div class="carousel-item ' . ($isActive ? 'active' : '') . '">
                        <div class="d-flex align-items-center justify-content-center p-3">
                            <img src="https://picsum.photos/400/250?random=1" class="rounded me-3" alt="ảnh 1" style="width:400px;height:250px;object-fit:cover;">
                            <div>
                                <a class="fw-bold text-decoration-none" href="#" >' . htmlspecialchars($row['news_title']) . ' </a>
                                <div class="text-limit">
                                    <p class="text-muted mb-0">'
                                . htmlspecialchars($row['news_description']) .
                                '</p>
                                </div>
                                <p class="mt-5">Ngày đăng: ' . htmlspecialchars($row['post_date'])  . '</p>
                            </div>
                        </div>
                    </div>
        ';
                            $isActive = false;
                        }
                    } else {
                        echo "<p>Không có dữ liệu.</p>";
                    }
                    ?>



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
            <div class="news-card my-3">
                <?php
                $category_id = 1; // ví dụ id chuyên mục
                $sql3 = "
                   SELECT n.*, c.name AS category_name
                    FROM news n
                    INNER JOIN category c ON n.category_id = c.category_id
                    INNER JOIN (
                        SELECT category_id, MIN(post_date) AS latest_post
                        FROM news
                        GROUP BY category_id
                    ) AS latest ON n.category_id = latest.category_id AND n.post_date = latest.latest_post;
                ";
                $result = $conn->query($sql3);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <span class="ms-3 fs-4 fw-bold">' . htmlspecialchars($row['category_name']) . '</span>
                <div class="card">
                    <div class="image-preview">
                        <img class="card-img-top" src="/Quiz_website/templates/assets/images/logo1.png" alt="Card-image-cap" />
                    </div>
                    <div class="card-body">
                        <div class="top">
                            <h5 class="card-title">' . htmlspecialchars($row['news_title']) . '</h5>
                            <div class="text-limit">
                                <p class="card-text">' . htmlspecialchars($row['news_description']) . '</p>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="views d-flex align-items-center gap-1 ">
                                <img src="\Quiz_website\templates\assets\images\visibility_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                                <p class="m-0">' . htmlspecialchars($row['views']) . '</p>
                            </div>
                            <div class="Post-date d-flex align-items-center ">
                                <p class="m-0">' . htmlspecialchars($row['post_date']) . '</p>
                            </div>
                            <button class="btn btn-primary">View more</button>
                        </div>
                    </div>
                </div>
                        ';
                    }
                } else {
                    echo "<p>Không có dữ liệu.</p>";
                }
                ?>

            </div>

        </div>
        <div class="right-container"></div>
    </div>
    <div class="footer container">

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>