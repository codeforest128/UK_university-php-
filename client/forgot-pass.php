<?php
    include_once "../../classes/DB.php";
    
    if (isset($_POST["pass-reset"]) || isset($_GET["email"])) {
        if (isset($_POST["email"])) {
            $to = array($_POST["email"]);
        } else {
            $to = array($_GET["email"]);
        }

        $email_x = $_POST['email'];

        
        // $cstrong = True;
        // $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

         



        // DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

        // $name = DB::query("SELECT firstname FROM `posts` WHERE user_id=:uid", array(":uid" => $user_id))[0]["firstname"];

        $name = '';
        $token = '';

        $client = DB::query('SELECT * FROM clients WHERE email="'.$email_x.'"');

        foreach ($client as $key => $value) {
        	$name = $value['username'];
        	$token = md5($value['id']);
        }

        if ($token!='') {
        	$smtp_details = array("account" => "noreply@oxbridgecareershub.co.uk", "pass" => "Nephthys60");
	        $from_name = "OCH Team";
	        $subject = "OCH | Forgotten password";
	        $message = "<p>Hi " . $name . ",</p>
			            <p>To reset your OCH password please follow this <a target='_blank' href='https://www.varsitycareershub.co.uk/dev01/client/reset-password.php?token=" . $token . "'>link</a>.</p>
			            <p>If you did not request a password reset, you can safely ignore this email</p>
			            <p><strong>The OCH Team</strong></p>";
	        mailer_man($smtp_details, $from_name, $subject, $message, $to);

	        $_SESSION['flash'] = '<h3 class="title three">A link has been sent to your email address</h3>';
        }else{
        	$_SESSION['flash'] = 'Invalid Account';

        }

    }
?>
<!DOCTYPE html>
<html>
<?php
    $title = "Forgot Password";
    include_once "components/header.php";
?>
<body>
    <?php
           include_once "components/simple_navbar.php";
    ?>
    <div class="banner_bottom">
		<div class="container">
		    <?php
		        if(!isset($_POST["pass-reset"]) && !isset($_GET["email"])) {
		    ?>
			<div class="tittle_head">
				<h3 class="tittle three">Please provide an email for password reset</h3>
			</div>
			<div class="inner_sec_info">
				<div class="signin-form">
					<div class="login-form-rec">
						<form action="#" method="post">
							<input type="email" name="email" placeholder="E-mail" required="">
							<div class="tp">
								<input type="submit" name="pass-reset">
							</div>
						</form>
					</div>
					<p style="margin-top: 20px;"><a href="signup.php"> Don't have an account?</a></p>
				</div>
			</div>
			<?php
		        } else {
		    ?>
		    <div class="title_head">
		        
		        &nbsp;
		    </div>
		    <div class="inner_sec_info">
				<div class="signin-form">
					<div class="login-form-rec" style="min-height: 200px;">
						<?php echo $_SESSION['flash']; unset($_SESSION['flash']);  ?>
					</div>
				</div>
			</div>
		    <?php
		        }
		    ?>
		</div>
	</div>
    <?php
         include_once "components/new_footer.php";
    ?>
</body>
</html>
