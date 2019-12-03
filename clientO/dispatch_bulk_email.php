<!DOCTYPE html>
<html>
    <body>
<?php
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
    if (Login::isClientLoggedIn() && isset($_POST["email-body"])) {
        # Get client ID
        if (isset($_COOKIE["SNID"])) {
            $token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
        } else {
            header("Location: account.php");
        }
        
        # Record occurrence
        $sql = "INSERT INTO `inhouse_email_tracking` (`client_id`, `student_ids`, `content`, `subject`) "
             . "VALUES (:cid, :stids, :cntnt, :sbjct)";
        DB::query($sql, array(":cid" => $client_id, ":stids" => $_POST["student-ids"], ":cntnt" => $_POST["email-body"], "sbjct" => $_POST["email-subject"]));

        # Check they're able to send an email to that many people
        $student_list = json_decode($_POST["student-ids"]);
        $amount_sending_to = sizeof($student_list);
        if ($amount_sending_to == 0) {
            header("Location: database.php?be_res=0");
            exit;
        }
        if (isset($_POST["bulk"])) {
            $limit_left = DB::query("SELECT bulk_email FROM `client_limit_counters` WHERE client_id=:cid", array(":cid" => $client_id))[0]["bulk_email"];
            if ($amount_sending_to > $limit_left) {
                header("Location: database.php?be_res=1");
                exit;
            }
            # If they're able to, then update the table
            $new_amount_left = $limit_left - $amount_sending_to;
            DB::query("UPDATE `client_limit_counters` SET bulk_email=:nbe WHERE client_id=:cid", array(":nbe" => $new_amount_left, ":cid" => $client_id));
        }
        # Get email body and scrub for html
        if (isset($_POST["plain_text"]) && $_POST["plain_text"] == "off") {
            $email_body = $_POST["email-body"];
            $email_subject = $_POST["email-subject"];
        } else {
            $email_body = nl2br(strip_tags($_POST["email-body"]));
            $email_subject = strip_tags($_POST["email-subject"]);
        }
        
        # Begin to loop through student list to gather details, add to client contacts and increment number of times contacted within month
        $stu_cnt_incrmnt_sql = "UPDATE `posts` SET "
                             . "`times_contacted_this_month` = `times_contacted_this_month` + 1 "
                             . "WHERE user_id=:stid";
        $cnt_sql = "INSERT INTO `contacts` (client_id, student_id) "
                 . "VALUES (:cid, :stid)";
        $det_sql = "SELECT p.firstname, u.email FROM `posts` p "
                 . "LEFT OUTER JOIN `users` u "
                 . "ON p.user_id=u.id "
                 . "WHERE ";
        foreach($student_list as $student_id) {
            $det_sql .= "p.user_id=" . $student_id . " OR ";
            DB::query($cnt_sql, array(":cid" => $client_id, ":stid" => $student_id));
            echo "Executed first query";
            DB::query($stu_cnt_incrmnt_sql, array(":stid" => $student_id));
            echo "Executed second query";
        }
        $det_sql = substr($det_sql, 0, -4);
        echo "Sql for details: " . $det_sql;
        $student_details = DB::query($det_sql, null);
        # Now loop through student details and send email, adding in name
        foreach($student_details as $sd) {
            $specific_email_body = str_replace("{{fname}}", $sd["firstname"], $email_body);
            $from = $_POST["from"];
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From:" . $from . "\r\n";
            $to = array($sd["email"]);
            mailer_man($smtp_details, $from, $subject, $specific_email_body, $to);
        }
        header("Location: database.php?be_res=2");
    } else {
        header("Location: login.php");
    }
?>
</body>
</html>