<?php
error_reporting(-1);
include('../../classes/DB.php');
include('../../classes/login.php');
  $message = "";
  
  if (Login::isAdminLoggedIn()) {
	 header("Location: account.php");
  } 
 
if (isset($_POST['login'])) {
        $username = $_POST['email'];
        $password = $_POST['password'];
		
        if (DB::query('SELECT email FROM admin WHERE email=:username', array(':username'=>$username))) {
			
                if (password_verify($password, DB::query('SELECT password FROM admin WHERE email=:username', array(':username'=>$username))[0]['password'])) {
					$cstrong = True;
					$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
				
					$admin_id = DB::query('SELECT id FROM admin WHERE email=:username', array(':username'=>$username))[0]['id'];
					 
				//	$result = DB::query('SELECT * FROM client_details WHERE client_id =:client_id',array(':admin_id'=>$client_id));
		
					DB::query('INSERT INTO admin_login_tokens VALUES (\'\', :token, :admin_id)', array(':token'=>sha1($token), ':admin_id'=>$admin_id));
					
					setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
					setcookie("SNID_", $admin_id, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
					
					header ("Location: account.php");
		
                } else {
                        $message = 'Incorrect Password!';
                }
        } else {
                $message = 'Admin not registered!';
        }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Oxford Careers</title>
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
        <div class="container"><a class="navbar-brand logo" href="../index.php"><img src="../logo.png" style="height:60px;width:160px;"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="../index.php">Students</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../employers.php">Employers</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../about-us.html">About</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link text-primary" style="width:150px" href="login.php">Login / Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page shopping-cart-page"></main>
    <div class="login-clean">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-navigate" style="color: rgb(48,23,119);"></i></div>
			<p>Admin Login</p>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><label style="color:red"><?php echo $message ?></label></div>
            <div class="form-group"><input class="btn btn-primary btn-block" type="submit" value="Login" name="login" style="background-color: rgb(48,23,119);"></div><a href="forgot-pass.php" class="forgot">Forgot your email or password?</a><a href="signup.php" class="forgot">Don't have an Account?<strong> Sign Up</strong> </a></form>
    </div>
   <footer class="page-footer dark">
         <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="signup.php">Sign up</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="../about-us.html">About us</a></li>
                        <li><a href="../contact-us.php">Contact us</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="../contact-us.php">Get in touch</a></li>
                        <li><a href="../faqs.html">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="../TermsofUse.pdf" target="_blank">Terms of Use</a></li>
                        <li><a href="../Privacypolicy.pdf" target="_blank">Privacy Policy</a></li>
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
</body>

</html>