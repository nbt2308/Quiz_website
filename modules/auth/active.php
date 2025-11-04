<?php

layoutUser('header');


$filter = filterData('GET');


if (!empty($filter['token'])) {
    $token = $filter['token'];

    $sql = "SELECT * FROM user WHERE user_active_token = ?";

    //Chuẩn bị
    $stmt = $conn->prepare($sql);

    //Gán biến (Bind)
    // "s" có nghĩa là biến $token là kiểu String
    $stmt->bind_param("s", $token);

    //Thực thi
    $stmt->execute();

    //Lấy kết quả
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Lấy 1 hàng

    // Đóng
    $stmt->close();




?>

    <section class="mb-5">
        <div class="container-fluid h-custom">
            <div class="row d-flex flex-column justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5 d-flex justify-content-center align-items-center">
                    <img src="/News_website/templates/assets/images/TH.png"
                        class="img-fluid" alt="Sample image">
                </div>
                <?php
                if (!empty($user)) {
                    //thực hiện update dữ liệu (kích hoạt tài khoản người dùng: cập nhật trạng thái(đã kích hoạt), xoá active_token)
                    $data = [
                        'user_status' => TRUE,
                        'user_active_token' => null,
                    ];
                    $user_id = $user['user_id'];
                    $sql = "UPDATE user SET user_status=?, user_active_token=? WHERE user_id=?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt === false) {
                        die("Loi prepare SQL: " . $conn->error);
                    }
                    $status = (int)$data['user_status'];
                    //Gán biến (Bind)
                    // "s" có nghĩa là biến $token là kiểu String
                    $stmt->bind_param(
                        "isi",
                        $status,
                        $data['user_active_token'],
                        $user_id
                    );

                    //Thực thi
                    $stmt->execute();
                    $stmt->close();



                ?>
                    <div class="col-md-8 col-lg-6 col-xl-4 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start text-center">
                            <h2 class="fw-bold mb-5 me-3 ">Kích hoạt tài khoản thành công</h2>
                        </div>
                        <a href="?module=auth&action=login"
                            class="link-primary text-primary" style="font-size: 20px; color: blue !important;">Đăng nhập ngay</a>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-md-8 col-lg-6 col-xl-4 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start text-center">
                            <h2 class="fw-bold mb-5 me-3 ">Kích hoạt tài khoản không thành công. Link đã hết hạn hoặc không đúng</h2>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

<?php
    //đường link sai không hợp lệ
} else {
?>
    <section class="mb-5">
        <div class="container-fluid h-custom">
            <div class="row d-flex flex-column justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5 d-flex justify-content-center align-items-center">
                    <img src="/News_website/templates/assets/images/TH.png"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start text-center">
                        <h2 class="fw-bold mb-5 me-3 ">Link kích hoạt đã hết hạn hoặc không tồn tại</h2>
                    </div>
                    <a href="?module=auth&action=register"
                        class="link-primary text-primary" style="font-size: 20px; color: blue !important;">Quay trở lại</a>
                </div>
            </div>
        </div>
    </section>
<?php
}

?>
<?php
layoutUser("footer");
?>