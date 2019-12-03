<?php
include_once ('../classes/DB.php');

$users = DB::query('SELECT * FROM posts WHERE verified=0');

foreach($users as $user) {

$id = $user['user_id'];
$code = $id*4000;
$firstname = $user['firstname'];
$email = DB::query("SELECT email FROM users WHERE id = '$id'")[0]['email'];

   //$smtp_details = array("account" => "emily@varsitycareershub.co.uk", "pass" => "Mytho127");
                                $from_name = "VCH Team";
                                $subject = "VCH | Verify Account";
		                        $to = 'sebastian.g.aldous@durham.ac.uk';
                                $message1 = '<html><p>Dear '.$firstname.',</p><br/><p> Thank you very much for signing up to Varsity Careers Hub. Us and our companies are very excited to have you on the platform! </p><br/><br/><strong><p>In order for these companies to start contacting you please verify your account by clicking on this <a href="https://www.varsitycareershub.co.uk/account.php?id='.$code.'>link</a>.<br> We had some errors with our verification processes which have meant that some verified account are not appearing as verified so if you have received this email and believe you have verified your account already please verify it again anyway.<br/><p>We look forward to having you as an active profile on our site!</p><br/>
                                    Many thanks, <br>
                                    <p>Varsity Careers Hub Team</p></html>'; 

                       //         mailer_man($smtp_details, $from_name, $subject, $message1, $to);
                        echo($email.'<br>'.$message1.'<br><br>'); 

}

   $smtp_details = array("account" => "emily@varsitycareershub.co.uk", "pass" => "Mytho127");
                                $from_name = "VCH Team";
                                $subject = "VCH | Verify Account";
		                        $to = 'sebastian.g.aldous@durham.ac.uk';
                                  $message1 = '<html><p>Dear Sebsatian,</p><br/><p> Thank you very much for signing up to Varsity Careers Hub. Us and our companies are very excited to have you on the platform! </p><br/><br/><strong><p>In order for these companies to start contacting you please verify your account by clicking on this <a href="https://www.varsitycareershub.co.uk/account.php?id=qwerrtew">link</a></strong>.<br> We had some errors with our verification processes which have meant that some verified account are not appearing as verified so if you have received this email and believe you have verified your account already please verify it again anyway.<br/><p>We look forward to having you as an active profile on our site!</p><br/>
                                    Many thanks, <br>
                                    <p>Varsity Careers Hub Team</p></html>'; 

        mailer_man($smtp_details, $from_name, $subject, $message1, $to);
                        echo($email.'<br>'.$message1.'<br><br>'); 
?>