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
    
    $message = "";
    
	if (isset($_POST["password"])) {

        if ($_POST["new_password"] == $_POST["confirm_new_password"]) {
    		
    		$token = $_COOKIE['SNID'];
		    $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
	
    		$password = DB::query('SELECT * FROM clients WHERE id=:clientid', array(':clientid'=>$clientid))[0]['password'];
		
	    	$new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
		    if (password_verify($_POST['password'],$password)) {
			
			    $update = DB::query('UPDATE clients SET password=:password WHERE id=:id', array(':id'=>$clientid,':password'=>$new_password));
			    $_SESSION['flash'] = '<b class="text-success">Password Changed<b>';
			
		        header("Location: account.php");
    		} else {
	    		$message = "<h3 style='color: red; text-align: center;'>Current password incorrect!</h3><br/>";
		    }
        } else {
            $message = "<h3 style='color: red; text-align: center;'>New Passwords do not match</h3><br/>";
        }
	}
?>
<!DOCTYPE html>
<html style="height: 100%; background: #f8f9fa;">
    <?php
        include_once "components/header.php";
    ?>
    <body style="height: 100%; background: #f8f9fa;">
    <?php
        include_once "components/new_navbar.php";
    ?>
    <style>
        .submit-button {
            outline: none;
            padding: 0.8em 0;
            width: 100%;
            text-align: center;
            font-size: 1em;
            margin-top: 1em;
            border: none;
            color: #FFFFFF;
            text-transform: uppercase;
            cursor: pointer;
            background: #04003c;
            width: 40%;
            margin-left: 30%;
            box-shadow: 0px 2px 1px rgba(28, 28, 29, 0.42);
        }
        .submit-button:hover {
            color: #fff;
            background: #000;
            transition: .5s all;
            -webkit-transition: .5s all;
            -moz-transition: .5s all;
            -o-transition: .5s all;
            -ms-transition: .5s all;
        }
    </style>
    <div style="min-height: 70%; text-align: center;">
        <form method="POST" style="width: 50%; text-align: left; margin: 20% auto; padding: 4em; box-shadow: 1px 3px 5px rgba(134, 127, 127, 1); background: #fff;">
            <label>Current Password</label>
            <input type="password" name="password" class="form-control" required/>
            <br/>
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required/>
            <br/>
            <label>Confirm New Password</label>
            <input type="password" name="confirm_new_password" class="form-control" required/>
            <br/>
            <?php echo $message; ?>
            <input type="submit" class="submit-button">
        </form>
    </div>
    <?php
        include_once "components/new_footer.php";
    ?>
    </body>
</html>