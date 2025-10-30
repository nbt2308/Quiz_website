<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start(); //mo phien lam viec
ob_start(); //tranh loi khi dung ham header, cookie

require_once 'config.php';

try {
    header("Content-type: text/html; charset=utf-8");
    $conn = new mysqli(_HOST, _USER, _PASSWORD, _DBNAME);
    mysqli_set_charset($conn, 'UTF8');
    // Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
    if ($conn->connect_error) {
        die("Không kết nối :" . $conn->connect_error);
        exit();
    }
} catch (Exception $e) {
    echo "loi ket noi";
    exit();
}
require_once './modules/index.php';
?>