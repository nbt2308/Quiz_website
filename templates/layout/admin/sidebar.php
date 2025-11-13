<?php
$user_id = getSession("user_id");
$current_module = $_GET['module'] ?? '';
$current_action = $_GET['action'] ?? '';
?>
<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-primary shadow" data-bs-theme="light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand ">
        <!--begin::Brand Link-->
        <a href="?module=home&action=index" class="brand-link ">
            <!--begin::Brand Image-->
            <img width="60" height="60" src="/News_website/templates/assets/images/TH.png" alt="Logo-brand">
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light ">TH News</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper bg-light text-dark">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation">
                <li class="nav-item">
                    <a href="?module=admin&action=index&user_id=<?php echo $user_id ?>"
                        class="nav-link text-dark <?php echo ($current_module == 'admin' && $current_action == 'index') ? 'active' : ''; ?>">
                        <!-- <i class="nav-icon bi bi-speedometer"></i> -->
                        <img src="/News_website/templates/assets/images/readiness_score_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>

                <li class="nav-item" >
                    <a href="#" class="nav-link menu text-dark <?php echo ($current_module == 'news_management_admin') ? 'active' : ''; ?>">
                        <!-- <i class="nav-icon bi bi-box-seam-fill"></i> -->
                        <img src="/News_website/templates/assets/images/news_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <p>
                            News management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item">
                            <a href="?module=news_management_admin&action=listNews&user_id=<?php echo $user_id ?>"
                                class="nav-link text-dark <?php echo ($current_action == 'listNews') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>List news</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?module=news_management_admin&action=newsApproval&user_id=<?php echo $user_id ?>"
                                class="nav-link text-dark <?php echo ($current_action == 'newsApproval') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Post Approval</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">

                    <a href="?module=users_management&action=listUser&user_id=<?php echo $user_id ?>"
                        class="nav-link text-dark <?php echo ($current_module == 'users_management') ? 'active' : ''; ?>">
                        <!-- <i class="nav-icon bi bi-pencil-square"></i> -->
                        <img src="/News_website/templates/assets/images/account_circle_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <p>
                            User management
                        </p>
                    </a>

                </li>
                <li class="nav-item">

                    <a href="?module=news_category&action=listNewsCategory&user_id=<?php echo $user_id ?>"
                        class="nav-link text-dark <?php echo ($current_module == 'news_category') ? 'active' : ''; ?>">
                        <!-- <i class="nav-icon bi bi-pencil-square"></i> -->
                        <img src="/News_website/templates/assets/images/category_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <p>
                            Category management
                        </p>
                    </a>

                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->