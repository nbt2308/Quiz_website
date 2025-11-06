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
            <span>Manage website's news category name</span>
        </div>
        <div class="manageNews-content mb-5">
            <div class="manageNews-button my-3 mx-3">
                <a href="?module=news_category&action=addNewsCategory" class="btn btn-primary add-button">
                    <img class="add-icon" src="/News_website/templates/assets/images/add_circle_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt=""> Add News Category Name
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
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Category name</th>
                                <th scope="col">Total post</th>
                                <th scope="col">Date</th>
                                <th scope="col" width="13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT c.*, COUNT(n.news_id) AS total_news
                                    FROM category c
                                    LEFT JOIN news n ON c.category_id = n.category_id
                                    GROUP BY c.category_id, c.category_name";
                            $list = $conn->query($sql);
                            if ($list->num_rows > 0) {
                                while ($row = $list->fetch_assoc()) {
                                    echo '<th scope="row">' . $row["category_id"] . '</th>';
                                    echo '<td>' . $row["category_name"] . '</td>';
                                    echo '<td>' . $row["total_news"] . '</td>';
                                    echo '<td>' . $row["category_created_at"] . '</td>';

                                    echo '<td >
                                            <a href="?module=news_category&action=editNews&id=' . $row['category_id'] . '" class="btn btn-warning btn-sm">
                                                <img src="/News_website/templates/assets/images/edit_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Edit">
                                            </a>

                                            <a href="?module=news&action=deleteNews&id=' . $row['category_id'] . '" class="btn btn-danger btn-sm">
                                                <img src="/News_website/templates/assets/images/delete_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="Delete">
                                            </a>

                                            <a href="?module=news&action=viewNews&id=' . $row['category_id'] . '" class="btn btn-info btn-sm">
                                                <img src="/News_website/templates/assets/images/visibility_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.svg" alt="View">
                                            </a>

                                        </td>';

                                    echo '</tr>';
                                }
                            } else {
                                echo 'No data!';
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