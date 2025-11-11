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
    if (!$result || $result->num_rows == 0) {
        echo "Category not found";
        exit;
    }
    $category = $result->fetch_assoc();
}

//header
$dataTitle = [
    'title' => "View category",
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
                                <label class="form-label">Category name</label>
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
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">News of category</label>
                            <div class="form-control" style="height: auto; background:#e9ecef" disabled>
                                <?php
                                if ($category['total_news'] > 0) {
                                    $sql1 = "SELECT n.news_title 
                                FROM news n
                                WHERE n.category_id = $category_id";
                                    $result1 = $conn->query($sql1);
                                    $stt = 1;
                                    while ($news = $result1->fetch_assoc()) {
                                        echo '<p class="mb-1">(' . $stt . ') ' . htmlspecialchars($news['news_title']) . '</p>';
                                        $stt++;
                                    }
                                } else {
                                    echo '<p class="text-danger">No news!!!</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between mt-4">
                        <a onclick="history.back()" class="btn btn-secondary">Back</a>
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