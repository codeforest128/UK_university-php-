<?php     include_once "../../classes/DB.php";



$smtp_details = array("account" => "noreply@oxbridgecareershub.co.uk", "pass" => "Nephthys60");
$from_name = "OCH Team";
$subject = "OCH | Forgotten password";
$message = "<p>Hi ,</p>
            <p>To reset your OCH password please follow this <a href='https://oxbridgecareershub.co.uk/reset-password.php?token='>link</a>.</p>
            <p>If you did not request a password reset, you can safely ignore this email</p>
            <p><strong>The OCH Team</strong></p>";

            $to = array('rrgs@mailinator.com');
mailer_man($smtp_details, $from_name, $subject, $message, $to);





?>