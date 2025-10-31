<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['category'])|| empty($_POST['news_title']) || empty($_POST['news_sumary']) || empty($_POST['news_content']) || empty($_POST['image_description'])) {
            die("Error: Missing required fields.");
        } else {
            $category = $_POST['category'];
            $news_title = $_POST['news_title'];
            $news_summary = $_POST['news_sumary'];
            $news_content = $_POST['news_content']; //Fix
            $image_file = $_POST['news_content'];
            $image_description = $_POST['image_description'];
            $user_id = 1; // Fix
        }
        
    }
    // fix sql injection
    $sql = "INSERT INTO news (news_title, news_description, news_image, sumary, image_note, user_id, category_id) VALUES ('$news_title', '$news_content', '$image_file', '$news_summary', '$image_description', '$user_id', '$category')";
    mysqli_query($conn, $sql);
    require_once 'manageNews.php';
?>