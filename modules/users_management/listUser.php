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



//header
$user_name = $data['user_name'];
$dataTitle = [
    'title' => "List Users",
    'data' => $user_name
];
layoutAdminUseInclude("header", $dataTitle);
?>

<?php layoutAdmin("sidebar"); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->

        <?php layoutAdminUseInclude("breadcrumb", $dataTitle); ?>

        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content container">
        <!--begin::Container-->
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container-fluid">
                <!--begin::Row-->

                <div class="row mb-3 align-items-center">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <a href="?module=users_management&action=addUser&user_id=<?php echo $user_id; ?>" class="btn btn-primary w-100 w-md-auto">
                            <i class="fa-solid fa-plus"></i>
                            <span>Add new user</span>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 text-md-end">
                        <a href="?module=users_management&action=listUser&user_id=<?php echo $user_id; ?>" class="btn btn-outline-primary w-100 w-md-auto" title="Reload page">
                            <i class="fa-solid fa-arrows-rotate"></i> Reload
                        </a>
                    </div>
                </div>

                <div class="row mb-4">
                    <form class="row g-3" action="" method="get">
                        <input type="hidden" name="module" value="users_management">
                        <input type="hidden" name="action" value="listUser">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                        <div class="col-12 col-md-4">
                            <label for="filter_user_role" class="form-label fw-bold">Filter user role</label>
                            <select id="filter_user_role" class="form-select" name="filter_user_role">
                                <option value="" <?= $user_role === "" ? "selected" : "" ?>>None</option>
                                <option value="0" <?= $user_role === "0" ? "selected" : "" ?>>User</option>
                                <option value="1" <?= $user_role === "1" ? "selected" : "" ?>>Admin</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_user_status" class="form-label fw-bold">Filter user status</label>
                            <select id="filter_user_status" class="form-select" name="filter_user_status">
                                <option value="" <?= $user_status === "" ? "selected" : "" ?>>None</option>
                                <option value="0" <?= $user_status === "0" ? "selected" : "" ?>>Pending</option>
                                <option value="1" <?= $user_status === "1" ? "selected" : "" ?>>Activated</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="searchKey" class="form-label fw-bold">Search</label>
                            <div class="input-group">
                                <input id="searchKey" name="searchKey" class="form-control" type="text" placeholder="Username or email..." value="<?= htmlspecialchars($searchKey) ?>">
                                <button class="btn btn-success" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                </button>
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
<?php layoutAdminUseInclude("footer"); ?>