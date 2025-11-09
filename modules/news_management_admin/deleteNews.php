<?php
$news_id;
$user_id_current = getSession("user_id");
$user_name_current = getSession("user_name");
if (!empty($_GET['news_id'])) {
    $news_id = $_GET['news_id'];
}
$sql = "SELECT * 
            FROM news n, category c
            WHERE n.category_id = c.category_id AND n.news_id = $news_id";
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    echo "News not found";
    exit;
}
$news = $result->fetch_assoc();

if (isMethodPost()) {
    $filterArr = filterData();

    $sql = "DELETE FROM news WHERE news_id='$news_id'";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Loi prepare SQL: " . $conn->error);
    }

    //lưu vào biến để kiểm tra trạng thái
    $insert_success = $stmt->execute();

    if ($insert_success) {
        setSessionFlash('msg', 'Delete news succeed');
        setSessionFlash('msg_type', 'success');
        header("Location:?module=news_management_admin&action=listNews&user_id=$user_id_current");
    } else {
        setSessionFlash('msg', 'Delete news failed');
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
    'title' => "Delete news",
    'breadcrumb' => "List News",
    'data' => $user_name_current,
    'module' => 'news_management_admin',
    'action' => 'listNews'
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
                                <input type="text" class="form-control" value="<?= htmlspecialchars($news['category_name']) ?>" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($news['news_title']) ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Summary</label>
                                <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($news['news_summary']) ?></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Post Date</label>
                                <input type="text" class="form-control" value="<?= $news['news_post_date'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <?php
                            $content = $news['news_description']; // Lấy dữ liệu từ DB, ví dụ: &#60;p&#62;&#38;aacute;dasdasda&#60;/p&#62;

                            // Giải mã 2 lần
                            $decoded = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            ?>
                            <!-- <textarea class="form-control" rows="5" disabled><?php echo $decoded; ?></textarea> -->
                            <div style="border:1px solid #ccc; padding:10px; border-radius:5px; background-color: #e9ecef;">
                                <?php echo $decoded; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Views</label>
                                <input type="text" class="form-control" value="<?= $news['news_views'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="<?= $news['news_isPost'] ? 'Approved' : 'Not approved' ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Image</label><br>
                            <img width="500" height="auto" src="<?= $news['news_image_path'] ?>" class="img-fluid" alt="News Image">
                        </div>
                    </div>

                    <!-- Hình ảnh -->
                    <div class="mb-3">
                        <label class="form-label">Image Description</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($news['news_image_note']) ?>" disabled>
                    </div>
                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between mt-4">
                        <a onclick="history.back()" class=" btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-danger">Delete News</button>
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