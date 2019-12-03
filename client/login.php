<?php

include('../../classes/DB.php');
include('../../classes/login.php');
$message = "";
if (Login::isClientLoggedIn()) {
    header("Location: account.php");
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (DB::query('SELECT email FROM clients WHERE email=:email', array(':email' => $email))[0]['email']) {

        if (password_verify($password, DB::query('SELECT password FROM clients WHERE email=:email', array(':email' => $email))[0]['password'])) {
            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

            $client_id = DB::query('SELECT id FROM clients WHERE email=:email', array(':email' => $email))[0]['id'];

            $result = DB::query('SELECT * FROM client_details WHERE client_id =:client_id', array(':client_id' => $client_id));

            DB::query('INSERT INTO client_login_token VALUES (\'\', :token, :client_id)', array(':token' => sha1($token), ':client_id' => $client_id));

            setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("SNID_", $client_id, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

            header("Location: account.php");
        } else {
            $message = 'Incorrect Password!';
        }
    } else {
        $message = 'User not registered!';
    }
}
?>
<?php
    $page_title = "Login";
    include_once "components/header.php";
?>
<style type="text/css">
    

    .button_link{
        margin-top: 5px;
    padding: 0.8em 0;
    background: #04003c;
    box-shadow: 0px 2px 1px rgba(28, 28, 29, 0.42);
}

</style>
<body>
    <?php
        include_once "components/simple_navbar.php";
    ?>
    <div class="banner_bottom">
		<div class="container">
			<div class="tittle_head" style="margin-bottom: 3em;">
				<h3 class="tittle three">Log in to <span>your Account </span></h3>
			</div>
			<div class="inner_sec_info">
				<div class="signin-form">
					<div class="login-form-rec">
						<form action="#" method="post">
							<input type="email" name="email" placeholder="Email" required="">
							<input type="password" name="password" placeholder="Password" required="">
							<div class="form-group"><label style="color:red"><?php echo $message ?></label></div>
							<div class="tp">
								<input type="submit" value="login" name="login">
							</div>
                            <a href="sign_up.php" class="btn btn-primary btn-block button_link" style="">
                                Sign Up
                            </a>
						</form>
					</div>
				<!--	<p><a href="signup.php"> Don't have an account?</a></p> -->
					<p><a href="forgot-pass.php"> Forgotten your password?</a></p>
                    <p><?php echo $_SESSION['flash'];unset($_SESSION['flash']); ?></p>
				</div>
			</div>
		</div>
	</div>
    <?php
        include_once "components/new_footer.php";
    ?>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../assets/js/smoothproducts.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/Bootstrap-Tags-Input-1.js"></script>
    <script src="../assets/js/Bootstrap-Tags-Input.js"></script>
</body>
</html>