<?php
$Login = getSession("logged_in");
if (!$Login) {
    header("Location: ?module=auth&action=login");
}
$user_id;
if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();


//header
$user_name = $data['user_name'];
$dataTitle = [
    'title' => "Dashboard",
    'data' => $user_name
];
layoutAdminUseInclude("header", $dataTitle);
?>

<?php layoutAdmin("sidebar"); ?>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <?php layoutAdminUseInclude("breadcrumb", $dataTitle); ?>
        </div>
    </div>
    <div class="app-content container">
        <div class="container-fluid">

            <!-- Hàng small-box đầu tiên (4 cột) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <?php
                            $sql1 = "SELECT COUNT(user_id) as totalUsers FROM user";
                            $result1 = $conn->query($sql1);
                            $data1 = $result1->fetch_assoc();
                            $totalUser = $data1['totalUsers'];
                            ?>
                            <h3><?php echo $totalUser ?? 0; ?></h3>
                            <p>Total users</p>
                        </div>
                        <i class="small-box-icon bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <?php
                            $sql2 = "SELECT COUNT(news_id) as totalNews FROM news";
                            $result2 = $conn->query($sql2);
                            $data2 = $result2->fetch_assoc();
                            $totalNew = $data2['totalNews'];
                            ?>
                            <h3><?php echo $totalNew ?? 0; ?></h3>
                            <p>Total news</p>
                        </div>
                        <i class="small-box-icon bi bi-newspaper"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <?php
                            $sql3 = "SELECT COUNT(user_id) as totalAdmins FROM user WHERE user_role=1";
                            $result3 = $conn->query($sql3);
                            $data3 = $result3->fetch_assoc();
                            $totalAdmin = $data3['totalAdmins'];
                            ?>
                            <h3><?php echo $totalAdmin ?? 0; ?></h3>
                            <p>Total admins</p>
                        </div>
                        <i class="small-box-icon fa-solid fa-user-tie"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <?php
                            $sql4 = "SELECT COUNT(category_id) as totalCategories FROM category";
                            $result4 = $conn->query($sql4);
                            $data4 = $result4->fetch_assoc();
                            $totalCategory = $data4['totalCategories'];
                            ?>
                            <h3><?php echo $totalCategory ?? 0; ?></h3>
                            <p>Total news category</p>
                        </div>
                        <i class="small-box-icon bi bi-graph-up"></i>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <?php
                            $sql5 = "SELECT COUNT(*) AS pending_posts FROM news WHERE news_isPost = 0;";
                            $result5 = $conn->query($sql5);
                            $data5 = $result5->fetch_assoc();
                            $totalNewsPending = $data5['pending_posts']
                            ?>
                            <h3><?php echo $totalNewsPending ?? 0; ?></h3>
                            <p>Pending posts</p>
                        </div>
                        <i class="small-box-icon fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-secondary">
                        <div class="inner">
                            <?php
                            $sql_total = "SELECT COUNT(*) AS total FROM user";
                            $sql_active = "SELECT COUNT(*) AS active FROM user WHERE user_status = 1";
                            $result_total = $conn->query($sql_total);
                            $result_active = $conn->query($sql_active);
                            $total = $result_total->fetch_assoc()['total'];
                            $active = $result_active->fetch_assoc()['active'];
                            $percent = 0;
                            if ($total > 0) {
                                $percent = ($active / $total) * 100;
                            }
                            $activeRate = round($percent, 2) . '%';
                            ?>
                            <h3><?php echo $activeRate; ?></h3>
                            <p>Active users rate</p>
                        </div>
                        <i class="small-box-icon fa-solid fa-key"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-light text-dark"> 
                        <div class="inner">
                            <?php
                            $sql6 = "SELECT COUNT(*) AS new_users_24h FROM user WHERE user_created_at >= NOW() - INTERVAL 1 DAY;";
                            $result6 = $conn->query($sql6);
                            $data6 = $result6->fetch_assoc();
                            $newUser = $data6['new_users_24h']
                            ?>
                            <h3><?php echo $newUser ?? 0; ?></h3>
                            <p>New users (24h)</p>
                        </div>
                        <i class="small-box-icon bi bi-stars me-2"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-light text-dark"> 
                        <div class="inner">
                            <?php
                            $sql7 = "SELECT COUNT(*) AS new_post_24h FROM news WHERE news_post_date >= NOW() - INTERVAL 1 DAY;";
                            $result7 = $conn->query($sql7);
                            $data7 = $result7->fetch_assoc();
                            $newPost = $data7['new_post_24h']
                            ?>
                            <h3><?php echo $newPost ?? 0; ?></h3>
                            <p>New posts (24h)</p>
                        </div>
                        <i class="small-box-icon bi bi-fire me-2"></i>
                    </div>
                </div>
            </div>

            <!-- Hàng Biểu đồ -->
            <div class="row">
                <!-- Biểu đồ đường (Line Chart) -->
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Activities last 7 days</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart" style="width:100%; max-height:300px"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ tròn (Doughnut Chart) -->
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">News by category</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" style="width:100%; max-height:300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // --- DỮ LIỆU CHO BIỂU ĐỒ ---

            // --- DỮ LIỆU BIỂU ĐỒ ĐƯỜNG (LINE CHART) ---

            // 1. Khởi tạo mảng 7 ngày
            $lineChartLabels = [];
            $user_data_map = [];
            $post_data_map = [];

            for ($i = 6; $i >= 0; $i--) {
                $day_key = date('Y-m-d', strtotime("-$i days"));
                $day_label = date('d/m', strtotime("-$i days"));

                $lineChartLabels[] = $day_label;
                $user_data_map[$day_key] = 0; // Khởi tạo số lượng user = 0
                $post_data_map[$day_key] = 0; // Khởi tạo số lượng post = 0
            }

            // 2. Truy vấn dữ liệu người dùng mới
            $sql_users = "SELECT DATE(user_created_at) AS creation_day, COUNT(user_id) AS user_count
                          FROM user
                          WHERE user_created_at >= NOW() - INTERVAL 7 DAY
                          GROUP BY creation_day";
            $result_users = $conn->query($sql_users);

            if ($result_users) {
                while ($row = $result_users->fetch_assoc()) {
                    if (isset($user_data_map[$row['creation_day']])) {
                        $user_data_map[$row['creation_day']] = (int)$row['user_count'];
                    }
                }
            }

            // 3. Truy vấn dữ liệu tin tức mới
            $sql_posts = "SELECT DATE(news_post_date) AS post_day, COUNT(news_id) AS post_count
                          FROM news
                          WHERE news_post_date >= NOW() - INTERVAL 7 DAY
                          GROUP BY post_day";
            $result_posts = $conn->query($sql_posts);

            if ($result_posts) {
                while ($row = $result_posts->fetch_assoc()) {
                    if (isset($post_data_map[$row['post_day']])) {
                        $post_data_map[$row['post_day']] = (int)$row['post_count'];
                    }
                }
            }

            // 4. Gán dữ liệu cuối cùng cho biểu đồ
            $newUserData = array_values($user_data_map);
            $newPostData = array_values($post_data_map);


            // --- [2] DỮ LIỆU BIỂU ĐỒ TRÒN (PIE CHART) ---
            $pieChartLabels = [];
            $pieChartData = [];

            // Dùng LEFT JOIN để lấy cả các danh mục có 0 bài viết
            $sql_pie = "SELECT c.category_name, COUNT(n.news_id) AS post_count
                        FROM category c
                        LEFT JOIN news n ON c.category_id = n.category_id
                        GROUP BY c.category_id, c.category_name
                        ORDER BY post_count DESC";

            $result_pie = $conn->query($sql_pie);

            if ($result_pie) {
                while ($row = $result_pie->fetch_assoc()) {
                    $pieChartLabels[] = $row['category_name'];
                    $pieChartData[] = (int)$row['post_count'];
                }
            }

            // Đảm bảo có dữ liệu, nếu không biểu đồ sẽ lỗi
            if (empty($pieChartLabels)) {
                $pieChartLabels = ['No data available'];
                $pieChartData = [0]; // Hiển thị 0
            }

            ?>

            <!-- Script cho các biểu đồ -->
            <script>
                // --- Khởi tạo Biểu đồ đường (Line Chart) ---
                const ctxLine = document.getElementById('lineChart');
                if (ctxLine) {
                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($lineChartLabels); ?>,
                            datasets: [{
                                    label: 'New users',
                                    data: <?php echo json_encode($newUserData); ?>,
                                    borderColor: 'rgb(13, 110, 253)',
                                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                    fill: true,
                                    tension: 0.3
                                },
                                {
                                    label: 'New posts',
                                    data: <?php echo json_encode($newPostData); ?>,
                                    borderColor: 'rgb(25, 135, 84)',
                                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                                    fill: true,
                                    tension: 0.3
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });
                }

                // --- Khởi tạo Biểu đồ tròn (Pie Chart) ---
                const ctxPie = document.getElementById('pieChart');
                if (ctxPie) {
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: <?php echo json_encode($pieChartLabels); ?>,
                            datasets: [{
                                label: 'Số lượng tin',
                                data: <?php echo json_encode($pieChartData); ?>,
                                backgroundColor: [
                                    'rgb(220, 53, 69)',
                                    'rgb(255, 193, 7)',
                                    'rgb(255, 0, 157)',
                                    'rgb(64, 225, 32)',
                                    'rgba(0, 38, 253, 1)',
                                    'rgba(147, 109, 244, 1)',
                                    'rgb(32, 201, 151)'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });
                }
            </script>

        </div>
    </div>
</main>

<?php layoutAdmin("footer"); ?>