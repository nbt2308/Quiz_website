<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['category'])|| empty($_POST['news_title']) || empty($_POST['news_summary']) || empty($_POST['news_content']) || empty($_POST['image_description'])) {
            die("Error: Missing required fields.");
        } else {
            $news_id = $_POST['news_id'];
            $category_id = $_POST['category'];
            $news_title = $_POST['news_title'];
            $news_summary = $_POST['news_summary'];
            $news_description = $_POST['news_content'];
            $news_image_note = $_POST['image_description'];
        }
    $news_image_path = '';
    if (!empty($_FILES['image_file']['name'])) {
        $targetDir = 'templates/uploads/';
        $targetFile = $targetDir . $news_title . "_" . basename($_FILES['image_file']['name']);
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
            $news_image_path = $targetFile;
        } else {
            die("Không thể upload ảnh!");
        }
        $sql = "UPDATE news
                SET news_title = '$news_title',
                    news_summary = '$news_summary',
                    news_description = '$news_description',
                    news_image_path = '$news_image_path',
                    news_image_note = '$news_image_note',
                    category_id = '$category_id'
                WHERE news_id = $news_id";
    }       
    }
    $sql = "UPDATE news 
            SET news_title = '$news_title',
                news_summary = '$news_summary',
                news_description = '$news_description',
                news_image_note = '$news_image_note',
                category_id = '$category_id'
            WHERE news_id = $news_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ?module=news&action=manageNews");
    } else {
        echo "Error editing news: " . $conn->error;
    }
    $conn->close();
?>