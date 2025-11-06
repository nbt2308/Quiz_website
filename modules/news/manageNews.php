<?php
layoutUser('header');
$Login = getSession("logged_in");
if (!$Login) {
    header("Location: ?module=auth&action=login");
}
?>

<main>
    <div class="manageNews-container container">
        <div class="manageNews-title my-3">
            <span>Manage your post</span>
        </div>
        <div class="manageNews-content mb-5">
            <div class="manageNews-button my-3 mx-3">
                <a href="?module=news&action=addNews" class="btn btn-primary add-button">
                    <img class="add-icon" src="/News_website/templates/assets/images/add_circle_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt=""> Add News
                </a>
            </div>
            <div class="search mb-3 mx-3">
                <form class="d-flex" action="?module=news&action=searchNews" method="POST">
                    <div class="search-box me-2">
                        <img class="search-icon" src="/News_website/templates/assets/images/search_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.svg" alt="">
                        <input name="searchKey" class="form-control" type="text" placeholder="Enter the title or category news" aria-label="Search">
                    </div>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="table-with-paginate">
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM category, news WHERE news.category_id = category.category_id";
                                $list = $conn->query($sql);
                                if ($list->num_rows > 0)
                                    while ($row = $list->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<th scope="row">' . $row["news_id"] . '</th>';
                                        echo '<td>' . $row["category_name"] . '</td>';
                                        echo '<td>' . $row["news_title"] . '</td>';
                                        echo '<td>' . $row["news_post_date"] . '</td>';
                                        if ($row["news_isPost"] == 1) {
                                            echo '<td>Approved</td>';
                                        } else {
                                            echo '<td>Not yet approved</td>';
                                        }

                                        echo '<td>
                                                <a href="?module=news&action=viewNews&id=' . $row['news_id'] . '" class="btn btn-info btn-sm">
                                                    <img src="/News_website/templates/assets/images/visibility_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="View">
                                                </a>
                                            </td>

                                            <td>
                                                <a href="?module=news&action=editNews&id=' . $row['news_id'] . '" class="btn btn-warning btn-sm">
                                                    <img src="/News_website/templates/assets/images/edit_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Edit">
                                                </a>
                                            </td>

                                            <td>
                                                <a href="?module=news&action=deleteNews&id=' . $row['news_id'] . '" class="btn btn-danger btn-sm">
                                                    <img src="/News_website/templates/assets/images/delete_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Delete">
                                                </a>
                                            </td>';

                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
layoutUser('footer');
?>