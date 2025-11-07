<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['news_id'])) {
        $user_id = getSession('user_id');
        $news_id = $_POST['news_id'];

        $sql = "DELETE FROM news WHERE news_id = $news_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: ?module=news&action=manageNews&user_id=$user_id");
            exit();
        } else {
            echo "Error deleting news: " . $conn->error;
        }
    }
    $conn->close();
}
?>