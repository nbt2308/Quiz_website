<?php
$user_id_current = getSession("user_id");
$user_name_current = getSession("user_name");
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $sql = "SELECT *, COUNT(n.news_id) AS total_news
            FROM category c
            LEFT JOIN news n ON c.category_id = n.category_id
            WHERE c.category_id = $category_id
            GROUP BY c.category_id, c.category_name";
    $result = $conn->query($sql);
    $category = $result->fetch_assoc();
}
if (isMethodPost()) {
    $filterArr = filterData();

    $sql = "DELETE c, n 
        FROM category c
        LEFT JOIN news n ON c.category_id = n.category_id
        WHERE c.category_id = $category_id";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Loi prepare SQL: " . $conn->error);
    }

    //lưu vào biến để kiểm tra trạng thái
    $insert_success = $stmt->execute();

    if ($insert_success) {
        setSessionFlash('msg', 'Delete category succeed');
        setSessionFlash('msg_type', 'success');
        header("Location:?module=news_category&action=listNewsCategory&user_id=$user_id_current");
    } else {
        setSessionFlash('msg', 'Delete category failed');
        setSessionFlash('msg_type', 'danger');
    }
    $stmt->close();
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
} else {
    $msg = "";
    $msg_type = '';
}
//header
$dataTitle = [
    'title' => "Delete category",
    'breadcrumb' => "List Category",
    'data' => $user_name_current,
    'module' => 'news_category',
    'action' => 'listNewsCategory'
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
                <form action="" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($category['category_name']) ?>" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Created at</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($category['category_created_at']) ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Total news</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($category['total_news']) ?>" disabled>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="?module=news_category&action=listNewsCategory&user_id=<?php echo $user_id_current; ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-danger">Delete Category</button>
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