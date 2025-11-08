<?php
$user_id;
if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
//Search handle
if (isMethodGet()) {
    $filterArr = filterData();

    if (isset($filterArr['filter_user_role'])) {
        $user_role = $filterArr['filter_user_role'];
    } else {
        $user_role = "";
    }
    if (isset($filterArr['filter_user_status'])) {
        $user_status = $filterArr['filter_user_status'];
    } else {

        $user_status =  "";
    }
    if (isset($filterArr['searchKey'])) {
        $searchKey = $filterArr['searchKey'];
    } else {


        $searchKey = "";
    }


    //Pagination
    $sql1 = "SELECT * FROM user";
    $stmt = $conn->prepare($sql1);
    if ($stmt === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt->execute();

    //Lấy kết quả
    $result1 = $stmt->get_result();
    $total_rows = $result1->num_rows;
    $stmt->close();
    $offset = 0;
    $perPage = 5; //tong so user/page
    $maxPage = ceil($total_rows  / $perPage); //tinh max page
    $filterArr = filterData('GET');
    $page = 1;
    if (isset($filterArr['page'])) {
        $page = $filterArr['page'];
    }

    if ($page > $maxPage || $page < 0) {
        $page = 1;
    }
    if (isset($page)) {
        $offset = ($page - 1) * $perPage;
    }

    $sql2 = "SELECT * FROM user 
            WHERE user_role LIKE '%$user_role%' 
            AND user_status LIKE '%$user_status%' 
            AND (user_name LIKE '%$searchKey%' OR user_email LIKE '%$searchKey%') ORDER BY user_id DESC LIMIT $offset, $perPage";
    $stmt1 = $conn->prepare($sql2);
    if ($stmt1 === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt1->execute();

    //Lấy kết quả
    $result2 = $stmt1->get_result();
} else {
    $user_role = "";
    $user_status =  "";
    $searchKey = "";
}



//query string 
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page=' . $page, '', $queryString);
}

//xử lý bảng rỗng
if (isset($user_role) || isset($user_status) || !empty($searchKey)) {
    $sql2 = "SELECT * FROM user 
            WHERE user_role LIKE '%$user_role%' 
            AND user_status LIKE '%$user_status%' 
            AND (user_name LIKE '%$searchKey%' OR user_email LIKE '%$searchKey%') ORDER BY user_id DESC";
    $stmt1 = $conn->prepare($sql2);
    if ($stmt1 === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt1->execute();

    //Lấy kết quả
    $result3 = $stmt1->get_result();
    $total_rows1 = $result3->num_rows;

    $maxPage = ceil($total_rows1 / $perPage);
}
?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User management</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
        name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta
        name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="stylesheet" href="/News_website/templates/assets/css/admin/adminlte.css">
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="/News_website/templates/assets/css/admin/adminlte.css">
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
        crossorigin="anonymous" />
    <!-- jsvectormap -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="/News_website/templates/assets/css/user/listUser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">

        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">



                    <!--begin::Fullscreen Toggle-->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <!--end::Fullscreen Toggle-->
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img
                                src="/News_website/templates/assets/images/person_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg"
                                class="user-image rounded-circle shadow"
                                alt="User Image" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Image-->
                            <li class="user-header text-bg-primary">
                                <img
                                    src="/News_website/templates/assets/images/person_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg"
                                    class="rounded-circle shadow"
                                    alt="User Image" />
                                <p><?php echo $data['user_name']; ?></p>
                            </li>
                            <!--end::User Image-->
                            <!--begin::Menu Body-->
                            <li class="user-body">
                                <a href="#" style="width: 100%;" class="btn btn-default btn-flat">Profile</a>
                            </li>
                            <!--end::Menu Body-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                <a href="#" style="width: 100%;" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <?php layoutAdmin("sidebar"); ?>
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->

                <?php layoutAdmin("breadcrumb"); ?>

                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content container">
                <!--begin::Container-->
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <div class="container-fluid">
                        <!--begin::Row-->

                        <div class="row">
                            <div class="col ">
                                <a href="?module=users_management&action=addUser&user_id=<?php echo $user_id; ?>" class="btn btn-primary mb-3">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add new user</span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <form class="d-flex gap-1" action="" method="get">
                                <input type="hidden" name="module" value="users_management">
                                <input type="hidden" name="action" value="listUser">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <div class="col-4">
                                    <select class="form-select mb-3" name="filter_user_role" aria-label="Default select example">
                                        <option value="" <?= $user_role === "" ? "selected" : "" ?>>None</option>
                                        <option value="0" <?= $user_role === "0" ? "selected" : "" ?>>User</option>
                                        <option value="1" <?= $user_role === "1" ? "selected" : "" ?>>Admin</option>
                                    </select>
                                </div>
                                <div class="col-4">

                                    <select class="form-select mb-3" name="filter_user_status" aria-label="Default select example">
                                        <option value="" <?= $user_status === "" ? "selected" : "" ?>>None</option>
                                        <option value="0" <?= $user_status === "0" ? "selected" : "" ?>>Pending</option>
                                        <option value="1" <?= $user_status === "1" ? "selected" : "" ?>>Activated</option>
                                    </select>
                                </div>
                                <div class="col-4 ">
                                    <div class="d-flex">
                                        <input name="searchKey" class="form-control" type="text" placeholder="Enter the title or category news" aria-label="Search" value="<?= htmlspecialchars($searchKey) ?>">
                                        <button class="btn btn-outline-success ms-1" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row ">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">USERNAME</th>
                                            <th scope="col">EMAIL</th>
                                            <th scope="col">ROLE</th>
                                            <th scope="col">ADDRESS</th>
                                            <th scope="col" style="width:105px;">STATUS</th>
                                            <th scope="col" colspan="3">ACTIONS</th>
                                            <!-- <th scope="col">VIEW</th>
                                            <th scope="col">EDIT</th>
                                            <th scope="col">DELETE</th> -->


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result2) {
                                            while ($row = $result2->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['user_id'] . '</td>';
                                                echo '<td>' . $row['user_name'] . '</td>';
                                                echo '<td>' . $row['user_email'] . '</td>';
                                                if ($row["user_role"] == 1) {
                                                    echo '<td>Admin</td>';
                                                } else {
                                                    echo '<td>User</td>';
                                                }
                                                echo '<td>' . $row['user_address'] . '</td>';
                                                if ($row["user_status"] == 1) {
                                                    echo '<td><i class="fa-solid fa-circle" style="color: #04ff00;"></i> Activated</td>';
                                                } else {
                                                    echo '<td><i class="fa-solid fa-circle" style="color: #f50000;"></i> Pending</td>';
                                                }
                                                echo '<td>';
                                                echo '<a class="btn btn-info" title="View user information" href="?module=users_management&action=viewUser&user_id=' . $row['user_id'] . '"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>';
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<a class="btn btn-warning mx-2" title="Edit user information" href="?module=users_management&action=editUser&user_id=' . $row['user_id'] . '"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></a>';
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<a class="btn btn-danger" title="Delete user" href="?module=users_management&action=deleteUser&user_id=' . $row['user_id'] . '"><i class="fa-solid fa-trash"></i></a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <nav aria-label="Page navigation example" class="">
                                <ul class="pagination">
                                    <!-- prev button -->
                                    <?php

                                    if ($page > 1) {
                                        echo '<li class="page-item"><a class="page-link rounded-0 rounded-start" href="?' . $queryString . '&page=' . ($page - 1) . '">Previous</a></li>';
                                    }
                                    $start = $page - 1;
                                    if ($start < 1) {
                                        $start = 1;
                                    }
                                    if ($start > 1) {
                                        echo '<li class="page-item"><a class="page-link rounded-0" href="?' . $queryString . '&page=' . ($page - 1) . '">...</a></li>';
                                    }

                                    ?>
                                    <?php
                                    $end = $page + 1;
                                    if ($end > $maxPage) {
                                        $end = $maxPage;
                                    }
                                    ?>

                                    <?php
                                    for ($i = $start; $i <= $end; $i++) {

                                        echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link rounded-0" href="?' . $queryString . '&page=' . $i . '">' . $i . '</a></li>';
                                    }
                                    ?>

                                    <!-- next button -->
                                    <?php

                                    if ($end < $maxPage) {
                                        echo '<li class="page-item"><a class="page-link rounded-0" href="?' . $queryString . '&page=' . ($page + 1) . '">...</a></li>';
                                    }
                                    if ($page < $maxPage) {
                                        echo '<li class="page-item"><a class="page-link rounded-0 rounded-end" href="?' . $queryString . '&page=' . ($page + 1) . '">Next</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>

                        <!--end::Row-->

                    </div>
                    <!--end::Container-->
                </div>
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <?php layoutAdmin("footer"); ?>