<?php
layoutUser("header");
$news_id;

if (!empty($_GET['news_id'])) {
    $news_id = $_GET['news_id'];
}
?>
<main>
    <div class="category container">
        <?php
        $sql = "SELECT * FROM category";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="category-title">
                        <a href="?module=news_category&action=index&category_id=' . htmlspecialchars($row['category_id']) . '"><strong>' . htmlspecialchars($row['category_name']) . '</strong></a>
                    </div>
        ';
            }
        } else {
            echo "<p>Không có dữ liệu.</p>";
        }
        ?>
        <!-- <div class="category-title"><a href="#"><strong>Breaking news</strong></a></div>
        <div class="category-title"><a href="#"><strong>World</strong></a></div>
        <div class="category-title"><a href="#"><strong>Business</strong></a></div>
        <div class="category-title"><a href="#"><strong>Sports</strong></a></div>
        <div class="category-title"><a href="#"><strong>Technology</strong></a></div>
        <div class="category-title"><a href="#"><strong>Health</strong></a></div>
        <div class="category-title"><a href="#"><strong>Entertainment</strong></a></div>
        <div class="category-title"><a href="#"><strong>Law</strong></a></div>
        <div class="category-title"><a href="#"><strong>Education</strong></a></div>
        <div class="category-title"><a href="#"><strong>Lifestyle</strong></a></div> -->
    </div>
    <div class="main-container container">
        <?php
        //in ten chu de
        $sql1 = "SELECT * FROM news, user WHERE news_id='$news_id' AND news.user_id=user.user_id";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        echo  '<div class="d-flex justify-content-between">';
        echo        '<p class="text-start text-secondary"><b>Posted by</b> ' . $row1['user_name'] . ' </p>';
        echo        '<p class="text-end text-secondary"> ' . $row1['news_post_date'] . ' </p>';
        echo  '</div>';
        echo  '<h3 class="title"> ' . $row1['news_title'] . ' </h3>';
        echo  '<p class="summary"> ' . $row1['news_summary'] . ' </p>';
        echo  '<div class="d-flex justify-content-center">';
        echo        '<img class="image img-fluid" height=auto width=500 src="' . $row1['news_image_path'] . '">';
        echo  '</div>';
        echo  '<p class="summary text-center"> <i>' . $row1['news_image_note'] . '</i> </p>';
        //giải mã ký tự từ db
        $decoded = html_entity_decode($row1['news_description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $decoded = html_entity_decode($row1['news_description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        echo  '<p class="content"> ' . $decoded . ' </p>';

        echo '<button type="button" class="btn btn-secondary mb-3" onclick="history.back()">Go back</button>';
        ?>
    </div>
    </div>
</main>
<?php
layoutUser("footer");
?>