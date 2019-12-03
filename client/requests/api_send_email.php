<?php
    include_once "../../../classes/DB.php";


        if (isset($_POST["hash"])) {

            $smtp_details = array("account" => "noreply@oxbridgecareershub.co.uk", "pass" => "Nephthys60");
$from_name = "VCH Team";
$subject = "VCH ";
$message = $_POST['message'];
$to[] = $_POST['email'];
mailer_man($smtp_details, $from_name, $subject, $message, $to);

        }
            

?>