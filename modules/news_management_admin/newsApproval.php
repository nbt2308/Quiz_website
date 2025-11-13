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


    if (isset($filterArr['filter_news_category'])) {
        $news_category = $filterArr['filter_news_category'];
    } else {

        $news_category =  "";
    }
    if (isset($filterArr['searchKey'])) {
        $searchKey = $filterArr['searchKey'];
    } else {
        $searchKey = "";
    }


    //Pagination
    $sql1 = "SELECT * FROM news";
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

    $sql2 = "SELECT * FROM news n, category c
            WHERE n.category_id = c.category_id 
            AND n.category_id LIKE '%$news_category%' 
            AND (n.news_title LIKE '%$searchKey%' OR c.category_name LIKE '%$searchKey%') 
            ORDER BY n.news_id DESC LIMIT $offset, $perPage";
    $stmt1 = $conn->prepare($sql2);
    if ($stmt1 === false) {
        die("Loi prepare SQL: " . $conn->error);
    }
    $stmt1->execute();

    //Lấy kết quả
    $result2 = $stmt1->get_result();
} else {

    $news_category =  "";
    $searchKey = "";
}



//query string 
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page=' . $page, '', $queryString);
}

//xử lý bảng rỗng
if (isset($news_category) || !empty($searchKey)) {
    $sql3 = "SELECT * FROM news n, category c
            WHERE n.category_id=c.category_id 
            AND n.category_id LIKE '%$news_category%' 
            AND (n.news_title LIKE '%$searchKey%' OR c.category_name LIKE '%$searchKey%') ORDER BY n.news_id DESC";
    $stmt1 = $conn->prepare($sql3);
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
    'title' => "News Approval",
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
                <div class="row">
                    <div class="col d-flex justify-content-end align-items-center">
                        <a href="?module=news_management_admin&action=newsApproval&user_id=<?php echo $user_id; ?>" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate" style="color: #ffffff;"></i></a>
                    </div>
                </div>
                <div class="row mb-4">
                    <form class="row g-3" action="" method="get">
                        <input type="hidden" name="module" value="news_management_admin">
                        <input type="hidden" name="action" value="newsApproval">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="col-12 col-md-4">
                            <label for="" class="fw-bold">Filter news category</label>
                            <select class="form-select mb-3" name="filter_news_category" aria-label="Default select example">
                                <option value="" <?= $news_category === "" ? "selected" : "" ?>>None</option>
                                <!-- lap data -->
                                <?php
                                $sql = "SELECT * FROM category";
                                $list = $conn->query($sql);
                                if ($list && $list->num_rows > 0) {
                                    while ($row = $list->fetch_assoc()) {
                                        $selected = ($news_category == $row["category_id"]) ? "selected" : "";
                                        echo '<option value="' . $row["category_id"] . '" ' . $selected . '>' . $row["category_name"] . '</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="searchKey" class="form-label fw-bold">Search</label>
                            <div class="input-group">
                                <input id="searchKey" name="searchKey" class="form-control" type="text" placeholder="Enter title or category..." aria-label="Search" value="<?= htmlspecialchars($searchKey) ?>">
                                <button class="btn btn-outline-success" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row ">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">DATE</th>
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
                                        echo '<td>' . $row['news_id'] . '</td>';
                                        echo '<td>' . $row['category_name'] . '</td>';
                                        echo '<td>' . $row['news_title'] . '</td>';
                                        echo '<td>' . $row['news_post_date'] . '</td>';
                                        if ($row["news_isPost"] === 1) {
                                            echo '<td><span class="badge bg-success">Approved</span></td>';
                                        } else {
                                            echo '<td><span class="badge bg-danger">Not approved</span></td>';
                                        }
                                        echo '<td>';
                                        echo '<a class="btn btn-md btn-info text-white" title="View news information" href="?module=news_management_admin&action=viewNews&user_id=' . $user_id . '&news_id=' . $row['news_id'] . '"><i class="bi bi-eye"></i> View</a>';
                                        echo '</td>';
                                        if ($row["news_isPost"] === 1) {
                                            echo '<td>';
                                            echo '<a class="btn btn-md btn-warning text-white" title="Unapprove news" href="?module=news_management_admin&action=unapproveNews&user_id=' . $user_id . '&news_id=' . $row['news_id'] . '"><i class="fa-solid fa-circle-xmark"></i>Unapprove</a>';
                                            echo '</td>';
                                        } else {
                                            echo '<td>';
                                            echo '<a class="btn btn-md btn-success mx-2 text-white" title="Approve news" href="?module=news_management_admin&action=approveNews&user_id=' . $user_id . '&news_id=' . $row['news_id'] . '"><i class="fa-solid fa-circle-check" style="color: #ffffff;"></i>Approve</a>';
                                            echo '</td>';
                                        }
                                        echo '<td>';
                                        echo '<a class="btn btn-danger" title="Delete news" href="?module=news_management_admin&action=deleteNews&user_id=' . $user_id . '&news_id=' . $row['news_id'] . '"><i class="fa-solid fa-trash"></i>Delete</a>';
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


        <!--end::App Content-->
</main>
<!--end::App Main-->
<?php layoutAdmin("footer"); ?>