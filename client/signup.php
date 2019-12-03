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


                        $sql = "INSERT INTO clients (username, password,email) VALUES ('" . $username . "','" . password_hash($password, PASSWORD_BCRYPT) . "','" . $email . "')";

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

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sign up - Oxford Careers</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="../assets/fonts/typicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Archivo+Black">
    <link rel="stylesheet" href="../assets/css/Bootstrap-Tags-Input.css">
    <link rel="stylesheet" href="../assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="../assets/css/Newsletter-Subscription-Form.css">
    <link rel="stylesheet" href="../assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="../assets/css/smoothproducts.css">
</head>

<body>

    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="logo" href="index.php"><img src="../logo.png" style="height:60px;width:160px;"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <!---------li class="nav-item" role="presentation"><a class="nav-link" href="index.php">Students</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="employers.php">Employers</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="about-us.html">About</a></li------>
                    <li class="nav-item" role="presentation"><a class="nav-link text-primary" style="width:150px" href="login.php">Login / Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page shopping-cart-page"></main>
    <div class="login-clean">
        <form method="post" onsubmit="check_form(event)">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-android-person" style="color: rgb(48,23,119);"></i></div>
            <center><b>Client SignUp</b></center>

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
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="signup.php">Sign up</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="about-us.html">About us</a></li>
                        <li><a href="contact-us.php">Contact us</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="contact-us.php">Get in touch</a></li>
                        <li><a href="faqs.html">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="TermsofUse.pdf" target="_blank">Terms of Use</a></li>
                        <li><a href="Privacypolicy.pdf" target="_blank">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2019 Oxford Careers Hub</p>
        </div>
    </footer>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../assets/js/smoothproducts.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/Bootstrap-Tags-Input-1.js"></script>
    <script src="../assets/js/Bootstrap-Tags-Input.js"></script>
    <script>
        var password = document.getElementById("password"),
            confirm_password = document.getElementById("confirm_password");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>


    <script>
        function check_form(e) {

            var chkpass = check_password();
            var chkemail = email_check();

            if (chkpass == false || chkemail == false) {
                e.preventDefault();
                return false;
            }

        }



        function check_password() {

            if ($('#password').val().length < 6) {

                $('#password_error').text('Password has to be atleast 6 characters');
                return false;
            } else {
                return true;
            }

        }

        /*  function email_check(){
              if($('#email').val().search('.ox.ac.uk')==-1){
                  $('#email_erroor').text('Please sign up with your university email address.');
                  return false;
              }else{
                  return true;
              } 
          }*/
    </script>

</body>

</html>