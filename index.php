<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start(); //mo phien lam viec
ob_start(); //tranh loi khi dung ham header, cookie

require_once 'config.php';
require_once './includes/connect.php';
require_once './includes/session.php';
require_once './includes/function.php';
//Test session
// setSesstion('nbt1','test session');
// $s=getSession('nbt1');
// echo $s;
// deleteSession("nbt1");


//gán 2 biến module và action là 2 biến hằng số được khai báo bên config.php
//để kiểm tra phương thức get trên url khi truy cập web và require đúng module mà người dùng đang muốn truy cập
$module = _MODULES;
$action = _ACTION;
if (!empty($_GET['module'])) {
    $module = $_GET['module'];
}
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$path = 'modules/' . $module . '/' . $action . '.php';
if (!empty($path)) {
    if (file_exists($path)) {

        require_once $path;
    } else {
        require_once './modules/errors/404.php';
    }
} else {
    require_once './modules/errors/500.php';
}
