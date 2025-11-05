<?php
layoutUser('header');
$Login = getSession("logged_in");
if (!$Login) {
    header("Location: ?module=auth&action=login");
}
if (isMethodPost('POST')) {
    $searchKey = $_POST['searchKey'];
}
?>

<main>
    <div class="manageNews-container container">
        <div class="manageNews-title my-3">
            <span>Results with keyword: <?php echo $searchKey ?></span>
        </div>
        <div class="manageNews-content">

            <div class="table-with-paginate">
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
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
                            if ($list->num_rows > 0) {
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

                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="6" >';
                                echo '<p class="fs-5 text-danger">Not found data with "' . $searchKey . '"</p>';
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