<?php
include('../classes/DB.php');
include('../classes/login.php');

    // 227 - 244
		/*		if (isset($_COOKIE['SNID']))	{			
				$token = $_COOKIE['SNID'];
				$userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id']; } */
				
				if (1 > 0) {

              		$id = DB::query('SELECT id, email, username FROM users');
              		
              		foreach($id as $test){
              		    
              		$itd = $test['id'];    
              		 $vef = DB::query('SELECT verified FROM verification WHERE userid = :id', array(':id'=>$itd))[0]['verified'];
              		 
              		 if ($vef == 0) {

              		  $code =  $test['id']*4000;
              		   
              		   
              		   
              		   
   /*         ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "noreply@oxfordcareershub.co.uk";//"u659159300@srv134.main-hosting.eu";
    $to =  $test['email'];
    $subject = "Verify your Oxbridge Careers Hub account";
    $message = '<html><p>Dear '.$test['username'].',</p><br/><p> Thank you for signing up to the Oxbridge Careers Hub database. We have noticed that you have not verified your email yet. </p><br/><br/><strong><p>To validate your email address and get your account online, click <a href="https://www.oxbridgecareershub.co.uk/account.php?id='.$code.'">here</a>. If you did not sign up to the database then please get in touch <a href="https://www.oxbridgecareershub.co.uk/contact-us.php">here</a>. </p></strong><br/><p>Thank you,</p><br/><p>Oxbridge Careers Hub Team</p></html>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" . $from . "\r\n";

    mail($to,$subject,$message, $headers); */
              
              		 echo($test['id'].'-'.$test['email'].'-'.$code.'-'.$vef.'<br/><p>Dear '.$test['username'].',</p><br/><p> Thank you for signing up to the Oxford Careers Hub database. We have noticed that you have not verified your email yet. </p><br/><br/><strong><p>To validate your email address and get your account online, click <a href="https://www.oxfordcareershub.co.uk/index.php?id='.$code.'">here</a>. If you did not sign up to the database then please get in touch <a href="https://www.oxfordcareershub.co.uk/contact-us.php">here</a>. </p></strong><br/><p>Thank you,</p><br/><p>Oxford Careers Hub Team</p>');  
              
              		}
				}
				}