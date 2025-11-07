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
    $category = $result->fetch_assoc();
}
?>

<main>
    <div class="container my-4">
        <h3 class="mb-4">Delete Category</h3>
        <form action="?module=news_category&action=deleteNewsCategory_handle" method="POST" class="p-4 border rounded bg-light">
            <input type="hidden" name="category_id" value="<?= $category_id ?>">

            <div class="mb-3">
                <label class="form-label">Category</label>
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

            <div class="d-flex justify-content-between mt-4">
                <a href="?module=news_category&action=listNewsCategory" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-danger">Delete News Category Name</button>
            </div>
        </form>
    </div>
</main>

<?php include_once 'templates/layout/user/footer.php'; ?>