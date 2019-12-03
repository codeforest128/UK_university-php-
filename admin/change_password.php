<?php	include('../../classes/DB.php');
	include('../../classes/login.php');
	
    if (!Login::isAdminLoggedIn()) {
         header("Location: login.php");
		}



		if (isset($_COOKIE['SNID']))	{			
			$token = $_COOKIE['SNID'];
			$admin_id = DB::query('SELECT admin_id FROM admin_login_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['admin_id'];

			
		}
		
		
		if(array_key_exists('logout',$_POST)){
			  DB::query('DELETE FROM admin_login_tokens WHERE admin_id=:admin_id', array(':admin_id'=>Login::isAdminLoggedIn()));
			  header("Location: login.php");
		}



	if (isset($_POST)) {
	
		
		 $token = $_COOKIE['SNID'];

            $admin_id = DB::query('SELECT admin_id FROM admin_login_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['admin_id'];

	
		$password = DB::query('SELECT * FROM admin WHERE id=:admin_id', array(':admin_id'=>$admin_id))[0]['password'];
		
		$new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

		
		if (password_verify($_POST['password'],$password)) {
			
			$update = DB::query('UPDATE admin SET password=:password WHERE id=:id', array(':id'=>$admin_id,':password'=>$new_password));
			$_SESSION['flash'] = '<b class="text-success">Password Changed<b>';
		}else{
			$_SESSION['flash'] = '<b class="text-danger">Error ! Old Password Does Not Match<b>';
		}              
	}
	
header("Location: account.php");
          
?>