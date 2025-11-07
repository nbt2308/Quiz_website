<?php
include_once 'templates/layout/user/header.php';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

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
$user_id = getSession('user_id');
?>

<main>
    <div class="container my-4">
        <h3 class="mb-4">View News Category Name</h3>

        <div class="p-4 border rounded bg-light">

            <div class="mb-3">
                <label class="form-label">Category name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($category['category_name']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Created at</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($category['category_created_at']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Total news</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($category['total_news']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">News of category</label>
                <div class="form-control" style="height: auto; min-height: 80px; background:#e9ecef" disabled>
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

            <a href="?module=news_category&action=listNewsCategory" class="btn btn-secondary mt-3">Back</a>

        </div>
    </div>
</main>

<?php include_once 'templates/layout/user/footer.php'; ?>