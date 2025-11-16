<?php layoutUser('header');

//validate data
if (isMethodPost()) {
    $filterArr = filterData();
    $errors = [];

    //validate username
    if (empty(trim($filterArr['user_name']))) {
        $errors['user_name']['required'] = "Username is required";
    }
    //Message
    if (empty(trim($filterArr['message']))) {
        $errors['message']['required'] = "Message is required";
    }
    //validate email
    if (empty(trim($filterArr['user_email']))) {
        $errors['user_email']['required'] = "Email is required";
    } else {
        //correct format
        if (!validateEmail(trim($filterArr['user_email']))) {
            $errors['user_email']['isEmail'] = "Email is invalid";
        }
    }


    if (empty($errors)) {
        $user_name = $filterArr['user_name'];
        $emailTo = 'thnewswebsite@gmail.com';
        $emailFrom = $filterArr['user_email'];
        $message = $filterArr['message'];
        $subjectEmail = "NEW CONTACT FORM SUBMISSION from: " . $user_name;

        // --- NỘI DUNG EMAIL PHẢN HỒI (Không phải nội dung kích hoạt tài khoản) ---
        $contentEmail = "Bạn nhận được một tin nhắn phản hồi mới từ website:\n\n";
        $contentEmail .= "Tên người gửi: " . $user_name . "\n";
        $contentEmail .= "Email phản hồi: " . $emailFrom . "\n";
        $contentEmail .= "Nội dung:\n" . $message;

        // Gọi hàm gửi mail đã sửa đổi
        $sendResult = sendMailFromUser($user_name, $emailTo, $emailFrom, $subjectEmail, $contentEmail);

        if ($sendResult) {
            setSessionFlash('msg', 'Send feedback succeed, We will respond to your feedback soon');
            setSessionFlash('msg_type', 'success');
        } else {
            setSessionFlash('msg', 'Send feedback failed due to an internal error.');
            setSessionFlash('msg_type', 'danger');
        }
    } else {
        setSessionFlash('msg', 'Send feedback failed');
        setSessionFlash('msg_type', 'danger');
    }

    $oldData = getSessionFlash('oldData');
    $errorsArr = getSessionFlash('errors');
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
} else {
    $msg = "";
    $msg_type = '';
    $oldData = "";
    $errorsArr = "";
}

?>
<style>
    .box-small {
        max-width: 800px;
        margin: 0 auto;
    }
</style>
<main>
    <div class="container">
        <div class="my-3 text-center fs-2 fw-bold">
            <span class="text-primary">Contact User</span><br>
            <span class="fs-6 fst-italic">We value your feedback. Please use the form below to send us your inquiries, comments, or news tips.</span>
        </div>


        <div class="box-small shadow p-3 mb-5 bg-body rounded">

            <?php getMsg($msg, $msg_type); ?>

            <form action="" method="POST" class="mt-3">
                <div class="row g-3">

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="user_email" class="form-label fw-bold">Email address (<span class="text-danger">*</span>)</label>
                            <input type="text" name="user_email" class="form-control" id="user_email" placeholder="Enter your email address"
                                value="<?php echo $oldData['user_email'] ?? ''; ?>" required>
                            <?php echo formErrors($errorsArr, 'user_email'); ?>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="user_name" class="form-label fw-bold">Your name (<span class="text-danger">*</span>)</label>
                            <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Enter your name" value="<?php echo $oldData['user_name'] ?? ''; ?>" required>
                            <?php echo formErrors($errorsArr, 'user_name'); ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="message" class="form-label fw-bold">Message</label>
                            <!-- Dữ liệu cũ cho CKEditor phải được đặt bên trong textarea -->
                            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Please enter the details of your message "><?php echo $oldData['message'] ?? ''; ?></textarea>
                            <?php echo formErrors($errorsArr, 'message'); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</main>

<?php layoutUser('footer'); ?>