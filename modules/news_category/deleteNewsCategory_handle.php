<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['category_id'])) {
        $user_id = getSession('user_id');
        $category_id = $_POST['category_id'];

        $sql = "DELETE FROM category WHERE category_id = $category_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: ?module=news_category&action=listNewsCategory");
            exit();
        } else {
            echo "Error deleting category: " . $conn->error;
        }
    }
    $conn->close();
}
?>