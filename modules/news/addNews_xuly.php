<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['category'])|| empty($_POST['news_title']) || empty($_POST['news_summary']) || empty($_POST['news_content']) || empty($_POST['image_description'])) {
            die("Error: Missing required fields.");
        } else {
            $category = $_POST['category'];
            $news_title = $_POST['news_title'];
            $news_summary = $_POST['news_summary'];
            $news_content = $_POST['news_content']; //Fix
            $image_file = $_POST['news_content'];
            $image_description = $_POST['image_description'];
            $user_id = 1; // Fix
        }
        
    }
    // fix sql injection
    $sql = "INSERT INTO news (news_title, news_summary, news_description, news_image_path, news_image_note, user_id, category_id) VALUES ('$news_title', '$news_content', '$image_file', '$news_summary', '$image_description', '$user_id', '$category')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ?module=news&action=manageNews");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
?>