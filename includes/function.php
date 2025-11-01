<?php
if (!defined('_PERMISSION')) {
    die("Truy cập không hợp lệ");
}

//hàm hỗ trợ require những layout cho trang admin
function layoutAdmin($layoutname)
{
    if (file_exists('./templates/layout/admin/' . $layoutname . '.php')) {
        require_once './templates/layout/admin/' . $layoutname . '.php';
    }
}
