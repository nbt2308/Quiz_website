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
function layoutUser($layoutname)
{
    if (file_exists('./templates/layout/user/' . $layoutname . '.php')) {
        require_once './templates/layout/user/' . $layoutname . '.php';
    }
}

//Function send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($emailTo, $subjectEmail, $contentEmail)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'thnewswebsite@gmail.com';                     //SMTP username
        $mail->Password   = _PASSWORD_EMAIL;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('thnewswebsite@gmail.com', 'TH News Website');
        $mail->addAddress($emailTo);     //Add a recipient




        //Content
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subjectEmail;
        $mail->Body    = $contentEmail;


        $mail->send();
        return $mail;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


//Kiểm tra phương thức get,post
function isMethodPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}
function isMethodGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}
//Function filter data 
function filterData($method = '')
{
    $filterArr = [];
    if (empty($method)) {
        if (isMethodGet()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    //strip_tags: loại bỏ tất cả html, php,.. trong 1 chuỗi và chỉ giữ lại chuỗi text
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //FILTER_REQUIRE_ARRAY: xử lý nếu value là dạng mảng
                        $filterArr[$key] = filter_input($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //FILTER_SANITIZE_SPECIAL_CHARS: lọc những ký tự đặc biệt
                        $filterArr[$key] = filter_input($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if (isMethodPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    //strip_tags: loại bỏ tất cả html, php,.. trong 1 chuỗi và chỉ giữ lại chuỗi text
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //FILTER_REQUIRE_ARRAY: xử lý nếu value là dạng mảng
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //FILTER_SANITIZE_SPECIAL_CHARS: lọc những ký tự đặc biệt
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
       
    } else {
        if ($method == 'get') {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    //strip_tags: loại bỏ tất cả html, php,.. trong 1 chuỗi và chỉ giữ lại chuỗi text
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //FILTER_REQUIRE_ARRAY: xử lý nếu value là dạng mảng
                        $filterArr[$key] = filter_input($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //FILTER_SANITIZE_SPECIAL_CHARS: lọc những ký tự đặc biệt
                        $filterArr[$key] = filter_input($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        } else if ($method == 'post') 
        {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    //strip_tags: loại bỏ tất cả html, php,.. trong 1 chuỗi và chỉ giữ lại chuỗi text
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //FILTER_REQUIRE_ARRAY: xử lý nếu value là dạng mảng
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //FILTER_SANITIZE_SPECIAL_CHARS: lọc những ký tự đặc biệt
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }
    return $filterArr;
}
