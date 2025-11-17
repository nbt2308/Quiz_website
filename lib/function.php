<?php

//hàm hỗ trợ require những layout cho trang admin
function layoutAdmin($layoutname, $dataTitle = [])
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
function layoutAdminUseInclude($layoutname, $dataTitle = [])
{
    if (file_exists('./templates/layout/admin/' . $layoutname . '.php')) {
        extract($dataTitle);
        include './templates/layout/admin/' . $layoutname . '.php';
    }
}

//Function send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMailFromUser($user_name, $emailTo, $emailFrom, $subjectEmail, $contentEmail)
{
   

    // Định nghĩa biến mật khẩu SMTP 
    $smtpPassword = _PASSWORD_EMAIL; 
    
    // Tạo một instance mới
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;      // Tắt debug trong môi trường production
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        // Tài khoản GỬI là tài khoản Admin (thnewswebsite@gmail.com)
        $mail->Username   = 'thnewswebsite@gmail.com';       
        $mail->Password   = $smtpPassword; // Mật khẩu ứng dụng của Admin
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465; 
        $mail->CharSet    = 'UTF-8';

        // Recipients (Người nhận)
        
        // 1. setFrom: Bắt buộc phải là tài khoản SMTP (Admin) để xác thực
        $mail->setFrom('thnewswebsite@gmail.com', 'Admin Website'); 

        // 2. addAddress: Người nhận chính là Admin
        $mail->addAddress($emailTo, 'Admin'); 
        
        // 3. addReplyTo: Đặt địa chỉ người dùng (người gửi form) làm địa chỉ trả lời
        $mail->addReplyTo($emailFrom, $user_name); 


        // Content
        $mail->isHTML(false); 
        $mail->Subject = $subjectEmail;
        $mail->Body    = $contentEmail;

        $mail->send();
        // Trả về true nếu gửi thành công
        return true; 
    } catch (Exception $e) {
        // Có thể ghi log lỗi thay vì echo trực tiếp ra màn hình
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
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
                        $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //FILTER_SANITIZE_SPECIAL_CHARS: lọc những ký tự đặc biệt
                        $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
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
        if ($method == 'GET') {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    //strip_tags: loại bỏ tất cả html, php,.. trong 1 chuỗi và chỉ giữ lại chuỗi text
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //FILTER_REQUIRE_ARRAY: xử lý nếu value là dạng mảng
                        $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //FILTER_SANITIZE_SPECIAL_CHARS: lọc những ký tự đặc biệt
                        $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        } else if ($method == 'POST') {
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

//------------VALIDATE----------------------
//Function validate email
function validateEmail($email)
{
    if (!empty($email)) {
        $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    return $checkEmail;
}

//Function validate int
function validateInt($number)
{
    if (!empty($number)) {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumber;
}


//function notification to user
function getMsg($msg, $type = 'success')
{

    echo '<div class="annouce-message alert alert-' . $type . '">';
    echo $msg;
    echo '</div>';
}

//function show error for input 
function formErrors($errors, $fieldName)
{
    return (!empty($errors[$fieldName]) ? '<div class="error text-danger ms-1">' . reset($errors[$fieldName]) . '</div>' : false);
}
//function fill old data
function showOldData($oldData, $fieldName)
{
    return (!empty($oldData[$fieldName]) ? $oldData[$fieldName] : null);
}
