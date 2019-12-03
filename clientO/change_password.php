<?php
include('../../classes/DB.php');
include('../../classes/login.php');

	if (!Login::isClientLoggedIn()) {
			 header("Location: login.php");
	}
	
	if (isset($_COOKIE['SNID']))	{			
		$token = $_COOKIE['SNID'];
		$clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
		
		$username = DB::query('SELECT username FROM clients WHERE id=:clientid', array(':clientid'=>$clientid))[0]['username'];
		
		$result = DB::query("SELECT * FROM client_details WHERE client_id = $clientid");
		$no = count($result);
	
	}

	if (isset($_POST)) {

		$token = $_COOKIE['SNID'];
	
		
		$clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
	
		$password = DB::query('SELECT * FROM clients WHERE id=:clientid', array(':clientid'=>$clientid))[0]['password'];
		
		$new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
		if (password_verify($_POST['password'],$password)) {
			
			$update = DB::query('UPDATE clients SET password=:password WHERE id=:id', array(':id'=>$clientid,':password'=>$new_password));
			$_SESSION['flash'] = '<b class="text-success">Password Changed<b>';
		}else{
			$_SESSION['flash'] = '<b class="text-danger">Error ! Old Password Does Not Match<b>';
		}              
	}
	
header("Location: account.php");
          
?>