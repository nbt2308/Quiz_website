<?php
$news_id;
$user_id = getSession('user_id');
$user_name_current = getSession("user_name");
if (!empty($_GET['news_id'])) {
    $news_id = $_GET['news_id'];
}
$sql = "SELECT * FROM news WHERE news_id='$news_id'";
$result = $conn->query($sql);
$news = $result->fetch_assoc();
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];

    //validate news title
    if (empty(trim($filterArr['news_title']))) {
        $errors['news_title']['required'] = "News title is required";
    } else {
        if (strlen(trim($filterArr['news_title'])) < 10) {
            $errors['news_title']['length'] = "News title must be 10 characters long";
        }
    }
    //validate news summary
    if (empty(trim($filterArr['news_summary']))) {
        $errors['news_summary']['required'] = "News summary is required";
    } else {
        if (strlen(trim($filterArr['news_summary'])) < 10) {
            $errors['news_summary']['length'] = "News summary must be 10 characters long";
        }
    }
    //validate news content
    if (empty(strip_tags(trim($filterArr['news_content'])))) {
        $errors['news_content']['required'] = "News content is required";
    } else {
        if (strlen(strip_tags(trim($filterArr['news_content']))) < 50) {
            $errors['news_content']['length'] = "News content must be 50 characters long";
        }
    }
    //validate image note
    if (empty(trim($filterArr['image_description']))) {
        $errors['image_description']['required'] = "Image description is required";
    } else {
        if (strlen(trim($filterArr['image_description'])) < 10) {
            $errors['image_description']['length'] = "Image description must be 10 characters long";
        }
    }
    //Xử lý dữ liệu từ input có áp dụng ckeditor
    $save_content = $conn->real_escape_string($filterArr['news_content']);
    //lấy user id từ session
    $user_id = getSession('user_id');
    if (empty($errors)) {
        //Xử lý dữ liệu image file thành đường dẫn
        $news_image_path = '';
        if (!empty($_FILES['image_file']['name'])) {
            $targetDir = 'templates/uploads/';
            $targetFile = $targetDir . $news_title . "_" . basename($_FILES['image_file']['name']);
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
                $news_image_path = $targetFile;
            } else {
                die("Không thể upload ảnh!");
            }

            $data = [
                'category_id' => $filterArr['category'],
                'news_title' => $filterArr['news_title'],
                'news_summary' => $filterArr['news_summary'],
                'news_description' => $save_content,
                'news_image_path' => $news_image_path,
                'news_image_note' => $filterArr['image_description'],
                'news_id' => $news_id
            ];
            $sql = "UPDATE news
                SET news_title = ?,
                    news_summary = ?,
                    news_description = ?,
                    news_image_path = ?,
                    news_image_note = ?,
                    category_id = ?
                WHERE news_id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Loi prepare SQL: " . $conn->error);
            }
            $stmt->bind_param(
                "sssssii", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string, int, string, string
                $data['news_title'],
                $data['news_summary'],
                $data['news_description'],
                $data['news_image_path'],
                $data['news_image_note'],
                $data['category_id'],
                $data['news_id']
            );
            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
        } else {
            $data_without_image = [
                'category_id' => $filterArr['category'],
                'news_title' => $filterArr['news_title'],
                'news_summary' => $filterArr['news_summary'],
                'news_description' => $save_content,
                'news_image_note' => $filterArr['image_description'],
                'news_id' => $news_id
            ];
            $sql = "UPDATE news
                SET news_title = ?,
                    news_summary = ?,
                    news_description = ?,
                    news_image_note = ?,
                    category_id = ?
                WHERE news_id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Loi prepare SQL: " . $conn->error);
            }
            $stmt->bind_param(
                "ssssii", //định dạng kiểu dữ liệu theo đúng thứ tự: string, string, string,string, int, int
                $data_without_image['news_title'],
                $data_without_image['news_summary'],
                $data_without_image['news_description'],
                $data_without_image['news_image_note'],
                $data_without_image['category_id'],
                $data_without_image['news_id']
            );
            //lưu vào biến để kiểm tra trạng thái
            $insert_success = $stmt->execute();
        }

        if ($insert_success) {
            header("Location: ?module=news_management_admin&action=listNews&user_id=$user_id");
        } else {
            setSessionFlash('msg', 'Invalid data, please check again');
            setSessionFlash('msg_type', 'danger');
        }
    } else {
        setSessionFlash('oldData', $filterArr);
        setSessionFlash('errors', $errors);
        setSessionFlash('msg', 'Invalid data, please check again');
        setSessionFlash('msg_type', 'danger');
    }
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
    $oldData = getSessionFlash('oldData');
    $errorsArr = getSessionFlash('errors');
} else {
    $msg = "";
    $msg_type = '';
    $oldData = "";
    $errorsArr = "";
}

//header

$dataTitle = [
    'title' => "Edit news",
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
                <?php getMsg($msg, $msg_type); ?>
                <form action="" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="category" class="form-label">Select category</label>
                                <select name="category" id="category" class="form-select">
                                    <?php
                                    $sql = "SELECT * FROM category";
                                    $categories = $conn->query($sql);
                                    while ($row = $categories->fetch_assoc()) {
                                        $selected = ($row['category_id'] == $news['category_id']) ? 'selected' : '';
                                        echo '<option value="' . $row['category_id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <?php
                                echo formErrors($errorsArr, 'category');
                                ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="news_title" class="form-label">News title</label>
                                <input name="news_title" id="news_title" type="text" class="form-control" placeholder="Enter news title" value="<?= htmlspecialchars($news['news_title']) ?>">
                                <?php
                                echo formErrors($errorsArr, 'news_title');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="news_summary" class="form-label">News summary</label>
                            <input name="news_summary" id="news_summary" type="text" class="form-control" placeholder="Enter short summary" value="<?= htmlspecialchars($news['news_summary']) ?>">
                            <?php
                            echo formErrors($errorsArr, 'news_summary');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="news_content" class="form-label">News content</label>
                            <?php
                            $content = $news['news_description']; // Lấy dữ liệu từ DB, ví dụ: &#60;p&#62;&#38;aacute;dasdasda&#60;/p&#62;

                            // Giải mã 2 lần
                            $decoded = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            ?>
                            <textarea name="news_content" id="news_content" class="form-control" rows="5" placeholder="Enter content here"><?php echo $decoded ?></textarea>
                            <script>
                                CKEDITOR.replace('news_content');
                            </script>
                            <?php
                            echo formErrors($errorsArr, 'news_content');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="formFileLg" class="form-label">Upload a news image</label>
                            <input name="image_file" class="form-control" id="formFileLg" type="file">
                            <div class="mb-2">
                                <p>Current image:</p>
                                <img src="<?= htmlspecialchars($news['news_image_path']) ?>" alt="Current image" style="max-width: 200px">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label for="image_description" class="form-label">Image description</label>
                            <input name="image_description" id="image_description" type="text" class="form-control" placeholder="Enter image description" value="<?= htmlspecialchars($news['news_image_note']) ?>">
                            <?php
                            echo formErrors($errorsArr, 'image_description');
                            ?>
                        </div>
                    </div>
                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="?module=news_management_admin&action=listNews&user_id=<?php echo $user_id; ?>" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Edit news</button>
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