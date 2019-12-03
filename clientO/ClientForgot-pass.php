
<?php
include("../classes/DB.php");
$status = "";
if (isset($_POST['resetpassword'])) {
        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $email = $_POST['email'];
        $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];
        DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
        echo 'Email sent!';
        echo '<br />';
           ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "noreply@oxfordcareershub.co.uk";//"u659159300@srv134.main-hosting.eu"; //"test@tester1602.online";
    $to = $_POST['email'];
    $subject = "Forgotten password";
    $message = "<html>
<head>
  <title>Reset password</title>
</head>
<body>
<p>Dear user,</p><br/>
  <h1>Please click this <a href='https://oxfordcareershub.co.uk/reset-password.php?token=$token'>link</a> to reset your password </h1>
  <br/><p>Thank you,</p><br/>
  <p>Oxford Careers Hub</p>
  
</body>
</html>";
    $headers = "From:oxfordcareershub<" . $from  . ">\r\n";
     $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'. "\r\n";
    mail($to,$subject,$message, $headers);
    $status= "An email detailing how to change your password has been sent.";
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Client Forgot Password - OCH</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/typicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Archivo+Black">
    <link rel="stylesheet" href="assets/css/Bootstrap-Tags-Input.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Newsletter-Subscription-Form.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/smoothproducts.css">
</head>

<body>
        <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="index.php"><img src="logo.png" style="height:60px;width:160px;"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="index.php">Students</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="employers.php">Employers</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="about-us.html">About</a></li>
					<li class="nav-item" role="presentation"><a class="nav-link text-primary" style="width:180px;color:#002366" href="ClientLogin.php">Client Login / Sign Up </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link text-primary" style="width:150px" href="login.php">Login / Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>
   <main class="page shopping-cart-page"></main>  
    <div class="login-clean">
        <form method="post">
            <h5 style="color:inherit;line-height: 3.2em;">Forgotten password?</h5>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email"><?=$status; ?>
            </div>
            <div class="form-group"><input class="btn btn-primary btn-block" type="submit" value="Send password" name="resetpassword" style="background-color: rgb(48,23,119);"></div><a href="ClientLogin.php" class="forgot">Remembered your details? Login here.</a><a href="ClientSignup.php" class="forgot">Don't have an Account?</a></form>
    </div>
     <style>
    .iframe {
   min-height:250px;
   width:100%;
   overflow:hidden;
   margin-bottom:-10px;
    }
    
    @media only screen and (max-width: 700px) {
 				
  .iframe {
   min-height:650px;
   width:100%;
    }		

  }
    </style>
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
</footer>    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/Bootstrap-Tags-Input-1.js"></script>
    <script src="assets/js/Bootstrap-Tags-Input.js"></script>
</body>

</html>