<?php
include('../../classes/DB.php');
include('../../classes/login.php');
if (Login::isClientLoggedIn()) {
    header("Location: account.php");
}



$message = "";
if (isset($_POST['createaccount'])) {


    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (strlen($username) >= 3 && strlen($username) <= 32) {
        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
            if (strlen($password) >= 6 && strlen($password) <= 60) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if (!DB::query('SELECT email FROM clients WHERE email=:email', array(':email' => $email))) {


                        $sql = "INSERT INTO clients (username, password,email,is_demo) VALUES ('" . $username . "','" . password_hash($password, PASSWORD_BCRYPT) . "','" . $email . "',1)";

                        DB::query($sql);


                        /*  DB::query('INSERT INTO clients VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));  */

                        print_r($_POST);

                        if (DB::query('SELECT email FROM clients WHERE email=:email', array(':email' => $email))) {
                            if (password_verify($password, DB::query('SELECT password FROM clients WHERE email =:email', array(':email' => $email))[0]['password'])) {

                                echo 'Logged in!';
                                $cstrong = True;
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                $client_id = DB::query('SELECT id FROM clients WHERE username=:username', array(':username' => $username))[0]['id'];
                                $code = ($user_id * 4000);
                                DB::query('INSERT INTO client_login_token VALUES (\'\', :token, :client_id)', array(':token' => sha1($token), ':client_id' => $client_id));
                                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                                echo 'see!';

                                $created_at = date("Y-m-d");

                                $sql = "INSERT INTO client_details (client_id, created_at) VALUES ('" . $client_id . "','" . $created_at . "')";

                                DB::query($sql);
                                echo 'seer!';

                                //  DB::query('INSERT INTO verification VALUES (\'\', :user_id, 0, :code)', array(':code'=>$code, ':user_id'=>$user_id));

                                ini_set('display_errors', 1);
                                error_reporting(E_ALL);
                                $from = "noreply@oxfordcareershub.co.uk"; //"u659159300@srv134.main-hosting.eu";
                                $to =  $_POST['email'];
                                $subject = "Verify Oxford Careers account";
                                $message = '<html><p>Dear ' . $username . ',</p><br/><p> Thank you for signing up to the Oxford Careers database. This email is to confirm that your email is correct. </p><br/><br/><strong><p>To validate your email address and get your account online, click <a href="https://www.oxfordcareershub.co.uk/index.php?id=' . $code . '">here</a>. If you did not sign up to the database then please get in touch <a href="https://www.oxfordcareershub.co.uk/contact-us.php">here</a>. </p></strong><br/><p>Thank you,</p><br/><p>Oxford Careers Hub Team</p></html>';
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                $headers .= "From:" . $from . "\r\n";

                                mail($to, $subject, $message, $headers);
                            }
                        }

                        // $_SESSION['flash'] = '<b class="text-success">Add Your Information<b>';
                        header("Location: account.php");;
                    } else {
                        $message = 'Email in use!';
                    }
                } else {
                    $message = 'Invalid email!';
                }
            } else {
                $message = 'Invalid password!';
            }
        } else {
            $message = 'Invalid username';
        }
    } else {
        $message = 'Invalid username';
    }
}

?>
<?php
    $page_title = "Sign Up";
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
				<h3 class="tittle three">Client SignUp</span></h3>
			</div>
			<div class="inner_sec_info">
				<div class="signin-form">
					<div class="login-form-rec">
						<form method="post" onsubmit="check_form(event)">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-android-person" style="color: rgb(48,23,119);"></i></div>
            

            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Full Name" style="margin-top: 15px;" required>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email" style="margin-top: 15px;" required></div>
            <span id="email_erroor" class="text-danger"></span>


            <div class="form-group">
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <span id="password_error" class="text-danger"></span>
            <div class="form-group">
                <input class="form-control" type="password" name="password" id="confirm_password" placeholder="Confirm Password" required>
            </div>
            <span id="error_password_confirm" class="text-danger"></span>
            <div class="form-group">
                <label style="color:red"><?php echo $message ?></label></div>

            <label style="font-size:12px;" class="form-check-label" for="formCheck-1"><input type="checkbox" style="display:inline-block" required> <b>Accept Our T & CS</b><br />I agree to Debut's <a target="_blank" href="TermsofUse.pdf">Terms of Use</a> and <a target="_blank" href="Privacypolicy.pdf">Privacy Policy</a></label>
            <br /><br />
            <label style="font-size:12px;" class="form-check-label" for="formCheck-1"><input type="checkbox" style="display:inline-block" required> <b>Allow Employers to contact you</b><br />I consent to my personal information being used by Debut to match me with career opportunities and to be contacted either by Debut or potential employers </label>
            <br /><br />

            <label style="font-size:12px;" class="form-check-label" for="formCheck-1"><input type="checkbox" style="display:inline-block" required> <b>Allow Debut to contact you</b><br />I consent to receive event invites, employers news , Debut updates and handy hints to help me along my career journey </label>
            <br /><br />

            <div class="form-group"><input class="btn btn-primary btn-block" type="submit" value="Sign Up" name="createaccount" style="background-color: #301777;"></div><a href="login.php" class="forgot">Already have an account? Login</a>
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