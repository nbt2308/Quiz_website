<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['category'])|| empty($_POST['news_title']) || empty($_POST['news_summary']) || empty($_POST['news_content']) || empty($_FILES['image_file']['name']) || empty($_POST['image_description'])) {
            die("Error: Missing required fields.");
        } else {
            $category_id = $_POST['category'];
            $news_title = $_POST['news_title'];
            $news_summary = $_POST['news_summary'];
            $news_description = $_POST['news_content'];
            $news_image_note = $_POST['image_description'];
            $user_id = 1; // Fix
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
    }
        
    }
    // fix sql injection
    $sql = "INSERT INTO news (news_title, news_summary, news_description, news_image_path, news_image_note, user_id, category_id) VALUES ('$news_title', '$news_summary', '$news_description', '$news_image_path', '$news_image_note', '$user_id', '$category_id')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ?module=news&action=manageNews");
    } else {
        echo "Error adding news: " . $conn->error;
    }
    $conn->close();
?>