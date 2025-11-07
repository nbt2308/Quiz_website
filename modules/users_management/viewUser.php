<?php
$user_id;
if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();




?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add New User</title>
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
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
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
                        <form action="" method="POST" enctype="multipart/form-data" class="p-4">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label fw-bold">Email address </label>
                                        <input type="text" name="user_email" class="form-control"
                                            id="exampleFormControlInput1" placeholder="Enter email address" disabled value="<?= htmlspecialchars($data['user_email']) ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label fw-bold">Password (<span class="text-danger">It cannot be seen here</span>)</label>
                                        <input type="password" name="user_password" class="form-control" id="exampleFormControlInput1" placeholder="Enter password" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label fw-bold">Username </label>
                                        <input type="text" name="user_name" class="form-control"
                                            id="exampleFormControlInput1" placeholder="Enter username" require value="<?= htmlspecialchars($data['user_name']) ?>" disabled>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label fw-bold">User role </label>

                                        <?php
                                        if (htmlspecialchars($data['user_role']) == 1) {
                                            echo '<input type="text" name="user_role" class="form-control"
                                                      id="exampleFormControlInput1" value="Admin" disabled>';
                                            // echo '<option value="0">User</option>
                                            //       <option selected value="1">Admin</option>';
                                        } else if (htmlspecialchars($data['user_role']) == 0) {
                                            echo '<input type="text" name="user_role" class="form-control"
                                                      id="exampleFormControlInput1" value="User" disabled>';
                                        }

                                        ?>


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="user_status" class="form-label fw-bold">User status </label>
                                    <?php
                                    if (htmlspecialchars($data['user_status']) == 1) {
                                        echo '<input type="text" name="user_status" class="form-control"
                                                      id="exampleFormControlInput1" value="Activated" disabled>';
                                        // echo '<option value="0">User</option>
                                        //       <option selected value="1">Admin</option>';
                                    } else if (htmlspecialchars($data['user_status']) == 0) {
                                        echo '<input type="text" name="user_status" class="form-control"
                                                      id="exampleFormControlInput1" value="Pending" disabled>';
                                    }

                                    ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="user_address" class="form-label fw-bold">User address</label>
                                    <input name="user_address" id="user_address" type="text"
                                        class="form-control" placeholder="Enter address" require value="<?= htmlspecialchars($data['user_address']) ?>" disabled>

                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3">
                                    <label for="user_bio" class="form-label fw-bold">Bio</label>
                                    <?php
                                    $content = $data['user_bio']; // Lấy dữ liệu từ DB, ví dụ: &#60;p&#62;&#38;aacute;dasdasda&#60;/p&#62;

                                    // Giải mã 2 lần
                                    $decoded = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    ?>
                                    <div style="border:1px solid #ccc; padding:10px; border-radius:5px; background-color: #e9ecef;">
                                        <?php echo $decoded; ?>
                                    </div>

                                </div>
                            </div>

                            <!-- Hình ảnh -->
                            <div class="row">
                                <div class="mb-3 d-flex flex-column">
                                    <label for="formFileLg" class="form-label fw-bold">User image (<span class="text-danger">*</span>)</label>
                                    <img src="<?= htmlspecialchars($data['user_image_path']); ?>" alt="User image" width="300" height="auto">
                                </div>
                            </div>
                            <!-- Nút hành động -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="?module=users_management&action=listUser&user_id=<?php echo $user_id; ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </form>


                        <!--end::Row-->

                    </div>
                    <!--end::Container-->
                </div>
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <?php layoutAdmin("footer"); ?>