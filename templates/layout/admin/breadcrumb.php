<?php
$module = $_GET['module'];
$action = $_GET['action'];
$user_id = getSession("user_id");
?>
<!--begin::Row-->
<div class="container p-lg-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 p-0">
                <h3 class="mb-0 fw-bold"><?php echo $dataTitle['title']; ?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="?module=home&action=index">Home</a></li>
                    <?php
                    if (!empty($dataTitle['breadcrumb'])) {
                        echo '<li class="breadcrumb-item"><a href="?module=' . $dataTitle['module'] . '&action=' . $dataTitle['action'] . '&user_id=' . $user_id . '">' . $dataTitle['breadcrumb'] . '</a></li>';
                    }
                    ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $dataTitle['title']; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--end::Row-->