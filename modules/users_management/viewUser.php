<?php
$user_id;
$user_id_current=getSession("user_id");
if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();



//header
$user_name = $data['user_name'];
$dataTitle = [
    'title' => "View user",
    'breadcrumb' => "List Users",
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
                        <a href="?module=users_management&action=listUser&user_id=<?php echo $user_id_current; ?>" class="btn btn-secondary">Back</a>
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