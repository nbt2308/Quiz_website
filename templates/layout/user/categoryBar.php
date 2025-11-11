<div class="container category my-2 p-3 rounded shadow-sm">
    <div class="d-flex flex-nowrap flex-md-wrap justify-content-start gap-2" style="scroll-behavior: smooth; overflow-x: auto;">
        <?php
        $current_category = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

        // Lấy tối đa 8 category
        $sql = "SELECT * FROM category ORDER BY category_id LIMIT 8";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $isActive = ($current_category === (int)$row['category_id']) ? 'btn-primary text-white' : 'btn-outline-primary';
                echo '
                    <a href="?module=news_category&action=index&category_id=' . htmlspecialchars($row['category_id']) . '" 
                       class="btn btn-sm rounded-pill px-3 fw-semibold ' . $isActive . ' flex-shrink-0">
                        ' . htmlspecialchars($row['category_name']) . '
                    </a>';
            }
        }

        // Dropdown “More”
        $offset = 8;
        $sql1 = "SELECT * FROM category ORDER BY category_id LIMIT 18446744073709551615 OFFSET $offset";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            echo '<div class="dropdown flex-shrink-0">';
            echo '<button class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold dropdown-toggle" 
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More
                      </button>';
            echo '<ul class="dropdown-menu">';
            while ($row1 = $result1->fetch_assoc()) {
                $isActive = ($current_category === (int)$row1['category_id']) ? 'active' : '';
                echo '<li>
                        <a class="dropdown-item ' . $isActive . '" 
                           href="?module=news_category&action=index&category_id=' . htmlspecialchars($row1['category_id']) . '">
                           ' . htmlspecialchars($row1['category_name']) . '
                        </a>
                      </li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
</div>
