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
            $client_email = DB::query('SELECT email FROM clients WHERE id=:client_id', array(':client_id' => $client_id))[0]['email'];
            
			$client_details = DB::query('SELECT * FROM clients WHERE id=:client_id', array(':client_id' => $client_id)) ;

            echo '<script>console.log($client_id)</script>';
        } else {
            header("Location: account.php");
        }
        
		
		//echo"<pre>"; print_r($client_details[0]->username);die;
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
        } else if ($amount_sending_to > 25) {
            header("Location: database.php?be_res=3");
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
            DB::query($stu_cnt_incrmnt_sql, array(":stid" => $student_id));
        }
        $det_sql = substr($det_sql, 0, -4);
        $student_details = DB::query($det_sql, null);
        # Now loop through student details and send email, adding in name

        $mail_sended = array();
        
        foreach($student_details as $sd) {
            $specific_email_body = str_replace("{{fname}}", $sd["firstname"], $email_body);
            // $from = $_POST["from"];
            $from = 'VCH';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From:" . $from . "\r\n";
            $to = array($sd["email"]);
            $smtp_details = array("account" => "noreply@varsitycareershub.co.uk", "pass" => "GqpZ38s4");
          // $result = mailer_man($smtp_details, $client_email[0], $email_subject, $specific_email_body, $to);
			
			
			$token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
           
		   $client_details = DB::query('SELECT * FROM clients WHERE id=:client_id', array(':client_id' => $client_id));
          
			$extra = 'Sender is - VCH on behalf of '.$client_details[0]['email'];
			
			$specific_email_body = $specific_email_body .'<br><br>'.$extra ;

            $specific_email_body = str_replace("{{fname}}",$client_details[0]['username'],$specific_email_body);
			
			  //echo"<pre>"; print_r($client_details); die;
			
			
            mailer_man_cc($smtp_details, $client_details[0]['username'], $email_subject, $specific_email_body, $to, $client_details[0]['email']); 
			/*  if($result){ 
				echo"sent"; die;
			}else{
				echo"faild"; die;
			}   */

            $mail_sended[$sd["email"]] = $sd["firstname"];
        }

        if (count($mail_sended)>0) {
            $_SESSION['mail_sended'] =  $mail_sended;
        }


        header("Location: database.php?be_res=2");
    } else {
        header("Location: login.php");
    }
?>
</body>
</html>