<?php
    include_once "../../classes/DB.php";
    die();
        $smtp_details = array("account" => "noreply@oxbridgecareershub.co.uk", "pass" => "Nephthys60");
        $from_name = "OCH Team";
        $subject = "OCH | Forgotten password";
        $message = "<p>Hi " . $name . ",</p>
		            <p>To reset your OCH password please follow this <a target='_blank' href='https://www.varsitycareershub.co.uk/dev01/reset-password.php?token=" . $token . "'>link</a>.</p>
		            <p>If you did not request a password reset, you can safely ignore this email</p>
		            <p><strong>The OCH Team</strong></p>";
        mailer_man($smtp_details, $from_name, $subject, $message, $to);
    }
?>
