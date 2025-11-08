<?php
layoutUser('header');
$Login = getSession("logged_in");
if (!$Login) {
    header("Location: ?module=auth&action=login");
}
if (isMethodPost('POST')) {
    $searchKey = $_POST['searchKey'];
}
$user_id = getSession('user_id');
?>

<main>
    <div class="manageNews-container container mb-5">
        <div class="manageNews-title my-3">
            <span>Results with keyword: <?php echo $searchKey ?></span>
        </div>
        <div class="manageNews-content">
            <div class="search mb-3 mx-3 mt-3">
                <form class="d-flex" action="?module=news&action=searchNews" method="POST">
                    <div class="search-box me-2">
                        <img class="search-icon" src="/News_website/templates/assets/images/search_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <input name="searchKey" class="form-control" type="text" value="<?php echo $searchKey ?>" placeholder="Enter the title or category news" aria-label="Search">
                        <a href="?module=news&action=manageNews&user_id=<?php echo $user_id ?>" class="reset-button">
                            <img src="/News_website/templates/assets/images/close_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        </a>
                    </div>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="table-with-paginate">
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Category</th>
                                <th scope="col">Title</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM category, news WHERE news.category_id = category.category_id AND (news_title LIKE '%$searchKey%' OR category_name LIKE '%$searchKey%')";
                            $list = $conn->query($sql);
                            $stt = 1;
                            if ($list->num_rows > 0) {
                                while ($row = $list->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $stt . '</th>';
                                    echo '<td class="text-start">' . $row["category_name"] . '</td>';
                                    echo '<td class="text-start">' . $row["news_title"] . '</td>';
                                    echo '<td>' . $row["news_post_date"] . '</td>';
                                    if ($row["news_isPost"] == 1) {
                                        echo '<td>Approved</td>';
                                    } else {
                                        echo '<td>Not yet approved</td>';
                                    }

                                    echo '<td >
                                            <a href="?module=news&action=editNews&id=' . $row['news_id'] . '" class="btn btn-warning btn-sm">
                                                <img src="/News_website/templates/assets/images/edit_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Edit">
                                            </a>

                                            <a href="?module=news&action=deleteNews&id=' . $row['news_id'] . '" class="btn btn-danger btn-sm">
                                                <img src="/News_website/templates/assets/images/delete_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Delete">
                                            </a>

                                            <a href="?module=news&action=viewNews&id=' . $row['news_id'] . '" class="btn btn-info btn-sm">
                                                <img src="/News_website/templates/assets/images/visibility_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="View">
                                            </a>

                                        </td>';
                                    $stt++;

                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="6" class="text-center py-4">';
                                echo '<div class="text-muted" style="font-size: 15px;">';
                                echo '<i class="bi bi-search fs-4 d-block mb-2"></i>';
                                echo 'No results found for "<strong>' . htmlspecialchars($searchKey) . '</strong>"';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
layoutUser('footer');
?>