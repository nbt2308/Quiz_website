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

    if (isset($filterArr['datetime-from'])) {
        $datetime_from = $filterArr['datetime-from'];
    } else {
        $datetime_from = "";
    }
    if (isset($filterArr['datetime-to'])) {
        $datetime_to = $filterArr['datetime-to'];
    } else {

        $datetime_to =  "";
    }
    if (isset($filterArr['searchKey'])) {
        $searchKey = $filterArr['searchKey'];
    } else {
        $searchKey = "";
    }

    $sql2 = "SELECT  c.*, COUNT(n.news_id) AS total_news
             FROM category c
             LEFT JOIN news n ON c.category_id = n.category_id
             WHERE 1";

    // Filter theo ngày
    if (!empty($datetime_from) && !empty($datetime_to)) {
        $sql2 .= " AND DATE(c.category_created_at) BETWEEN '$datetime_from' AND '$datetime_to'";
    } elseif (!empty($datetime_from)) {
        $sql2 .= " AND DATE(c.category_created_at) >= '$datetime_from'";
    } elseif (!empty($datetime_to)) {
        $sql2 .= " AND DATE(c.category_created_at) <= '$datetime_to'";
    }

    // Filter theo tên
    if (!empty($searchKey)) {
        $sql2 .= " AND c.category_name LIKE '%$searchKey%'";
    }




    //Pagination
    $sql1 = "SELECT * FROM category";
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

    $sql2 .= " GROUP BY c.category_id
               ORDER BY c.category_id DESC
               LIMIT $offset, $perPage";
    $stmt1 = $conn->prepare($sql2);
    if ($stmt1 === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt1->execute();

    //Lấy kết quả
    $result2 = $stmt1->get_result();
} else {
    $datetime_from = "";
    $datetime_to =  "";
    $searchKey = "";
}

//xử lý chuyển định dạng datetime để hiển thị ra ô input
if (!empty($datetime_from)) {
    $datetime_from_value = date('Y-m-d\TH:i', strtotime($datetime_from));
} else {
    $datetime_from_value = '';
}
if (!empty($datetime_to)) {
    $datetime_to_value = date('Y-m-d\TH:i', strtotime($datetime_to));
} else {
    $datetime_to_value = '';
}
//query string 
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page=' . $page, '', $queryString);
}

//xử lý bảng rỗng
if (isset($datetime_from) || isset($datetime_to) || !empty($searchKey)) {
    //xử lý datetime
    $sql2 = "SELECT  c.*, COUNT(n.news_id) AS total_news
             FROM category c
             LEFT JOIN news n ON c.category_id = n.category_id
             WHERE 1";

    // Filter theo ngày
    if (!empty($datetime_from) && !empty($datetime_to)) {
        $sql2 .= " AND DATE(c.category_created_at) BETWEEN '$datetime_from' AND '$datetime_to'";
    } elseif (!empty($datetime_from)) {
        $sql2 .= " AND DATE(c.category_created_at) >= '$datetime_from'";
    } elseif (!empty($datetime_to)) {
        $sql2 .= " AND DATE(c.category_created_at) <= '$datetime_to'";
    }

    // Filter theo tên
    if (!empty($searchKey)) {
        $sql2 .= " AND c.category_name LIKE '%$searchKey%'";
    }
    $sql2 .= " GROUP BY c.category_id
               ORDER BY c.category_created_at DESC";
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
    'title' => "List Category",
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
                        <a href="?module=news_category&action=addNewsCategory&user_id=<?php echo $user_id; ?>" class="btn btn-primary w-100 w-md-auto">
                            <i class="fa-solid fa-plus"></i> Add New Category
                        </a>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <a href="?module=news_category&action=listNewsCategory&user_id=<?php echo $user_id; ?>" class="btn btn-outline-primary w-100 w-md-auto"><i class="fa-solid fa-arrows-rotate"></i> Reload</a>
                    </div>
                </div>
                <div class="row mb-4">
                    <form class="row g-3" action="" method="get">
                        <input type="hidden" name="module" value="news_category">
                        <input type="hidden" name="action" value="listNewsCategory">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="col-12 col-md-4">
                            <!-- Return type: "yyyy-MM-ddThh:mm", cần thay chuỗi này thành "2025-11-10 14:30:00" để lưu vào db-->
                            <!-- giải pháp: str_replace -->
                            <label for="datetime-from" class="fw-bold">From</label>
                            <input type="datetime-local" class="form-control" name="datetime-from" value="<?= htmlspecialchars($datetime_from_value) ?>">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="datetime-to" class="fw-bold">To</label>
                            <input type="datetime-local" class="form-control" name="datetime-to" value="<?= htmlspecialchars($datetime_to_value) ?>">
                        </div>
                       <div class="col-12 col-md-4">
                            <label for="searchKey" class="fw-bold">Search</label>
                            <div class="input-group">
                                <input id="searchKey" name="searchKey" class="form-control" type="text" placeholder="Enter the category name" value="<?= htmlspecialchars($searchKey) ?>">
                                <button class="btn btn-success" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Category name</th>
                                    <th scope="col">Total post</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td class="text-center">' . $row["category_id"] . '</td>';
                                        echo '<td class="text-center">' . $row["category_name"] . '</td>';
                                        echo '<td class="text-center">' . $row["total_news"] . '</td>';
                                        echo '<td class="text-center">' . $row["category_created_at"] . '</td>';

                                        echo '
                                                <td >
                                                    <a href="?module=news_category&action=viewNewsCategory&user_id=' . $user_id . '&category_id=' . $row['category_id'] . '" class="btn btn-info btn-sm">
                                                        <img src="/News_website/templates/assets/images/visibility_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="View">
                                                    </a>

                                                </td>
                                                <td >
                                                    <a href="?module=news_category&action=editNewsCategory&user_id=' . $user_id . '&category_id=' . $row['category_id'] . '" class="btn btn-warning btn-sm">
                                                        <img src="/News_website/templates/assets/images/edit_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Edit">
                                                    </a>
                                                </td>
                                                
                                                <td >
                                                    <a href="?module=news_category&action=deleteNewsCategory&user_id=' . $user_id . '&category_id=' . $row['category_id'] . '" class="btn btn-danger btn-sm">
                                                        <img src="/News_website/templates/assets/images/delete_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Delete">
                                                    </a>
                                                </td>';

                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr>';
                                    echo '<td colspan="6" class="text-center py-4">';
                                    echo '<div class="text-muted" style="font-size: 14px;">';
                                    echo '<i class="bi bi-inbox fs-4 d-block mb-2"></i>';
                                    echo 'No data available';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
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