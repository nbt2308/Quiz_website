<div class="category container">
    <?php
    $sql = "SELECT * FROM category LIMIT 8";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
                    <div class="category-title">
                        <a href="?module=news_category&action=index&category_id=' . htmlspecialchars($row['category_id']) . '"><strong>' . htmlspecialchars($row['category_name']) . '</strong></a>
                    </div>';
        }
    } else {
        echo '<div class="text-muted " style="font-size: 14px; text-align:center;">';
        echo '<i class="bi bi-inbox fs-4 d-block mb-2 "></i>';
        echo '<p>No data available</p>';
        echo '</div>';
    }

    // More button
    $sql1 = "SELECT * FROM category WHERE category_id>8";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        while ($row1 = $result1->fetch_assoc()) {
            echo    '<div class="dropdown-center" style="z-index: 1;">
                            <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </a>

                            <!-- <span class="visually-hidden">Toggle Dropdown</span> -->
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?module=news_category&action=index&category_id=' . htmlspecialchars($row1['category_id']) . '">' . htmlspecialchars($row1['category_name']) . '</a></li>

                            </ul>
                        </div>';
        }
    }
    ?>
</div>