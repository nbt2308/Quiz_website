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
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/news/manageNews.css">
    <link rel="stylesheet" href="/Quiz_website/templates/assets/css/home/style.css">
</head>

<body>
    <div class="header container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand logo-brand" href="#"><img src="/Quiz_website/templates/assets/images/TH.png" alt="Logo-brand"></a>
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
    <div class="manageNews-container container">
        <div class="manageNews-title my-3">
            <span>Manage your post</span>
        </div>
        <div class="manageNews-content">
            <div class="manageNews-button my-3 mx-3">
                <button type="button" class="btn btn-primary add-button" data-bs-toggle="modal" data-bs-target="#modalAddNews">
                    <img class="add-icon" src="\Quiz_website\templates\assets\images\add_circle_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">Add News
                </button>
            </div>
            <div class="search mb-3 mx-3">
                <form class="d-flex">
                    <div class="search-box me-2">
                        <img class="search-icon" src="\Quiz_website\templates\assets\images\search_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <input class="form-control" type="search" placeholder="Enter the title or category news" aria-label="Search">
                    </div>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="table-with-paginate">
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $sql = "SELECT * FROM category, news WHERE news.category_id = category.category_id";
                        $list = $conn->query($sql);
                        if ($list->num_rows > 0)
                            while ($row = $list->fetch_assoc()) {
                                echo '<tbody>';
                                    echo '<tr>';
                                        echo '<th scope="row">' . $row["news_id"] . '</th>';
                                        echo '<td>' . $row["news_title"] . '</td>';
                                        echo '<td>' . $row["post_date"] . '</td>';
                                        if ($row["isPost"] == 1) {
                                            echo '<td>Approved</td>';
                                        } else {
                                            echo '<td>Not yet approved</td>';
                                        }
                                        echo '<td>' . $row["name"] . '</td>';

                                        echo '<td>
                                                <button type="button" class="btn btn-warning btn-sm"><img src="\Quiz_website\templates\assets\images\edit_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="Edit"></button>
                                                <button type="button" class="btn btn-danger btn-sm"><img src="\Quiz_website\templates\assets\images\delete_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="Delete"></button>
                                             </td>';
                
                                    echo '</tr>';
                                echo '</tbody>';
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>