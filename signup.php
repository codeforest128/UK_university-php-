<?php



    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
    
   /* ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/

    if (Login::isLoggedIn()) {
        header("Location: account.php");
    }
    
    // Check for reference code
    if (isset($_GET['ref'])) {
        $ref = $_GET['ref'];
    }
    
    $message = "";
    if (isset($_POST['fname'])) {

        $firstname = $_POST["fname"];
        $lastname = $_POST["lname"];
        $username = $firstname . " " . $lastname;
        $password = $_POST['password'];
        $passwordC = $_POST['password'];
        $email = $_POST['email'];

        $progress = true;

        if (strpos($email, '.ox.ac.uk') !== false) {
            $university = "University of Oxford";
        } else if (strpos($email, 'cam.ac.uk') !== false) {
            $university = "University of Cambridge";
        } else if (strpos($email, 'durham.ac.uk') !== false) {
            $university = "University of Durham";
        } else if (strpos($email, 'imperial.ac.uk') !== false) {
            $university = "Imperial College London";
        } else if (strpos($email, 'lse.ac.uk') !== false) {
            $university = "London School of Economics";
        } else if (strpos($email, 'ucl.ac.uk') !== false) {
            $university = "University College London";
        } else if (strpos($email, 'ic.ac.uk') !== false) {
            $university = "Imperial College London";
        
        }else {
            $message = "Please sign up with your university email";
            $progress = false;
        }
        
        if ($password != $passwordC) {
            $message = "The passwords do not match";
            $progress = false;
        }

        if (preg_match('/[a-zA-Z0-9_]+/', $username) && $progress) {
            if (strlen($password) >= 6 && strlen($password) <= 60) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email' => $email))) {
                        DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email)', array(':username' => $username, ':password' => password_hash($password, PASSWORD_BCRYPT), ':email' => $email));
                        if (DB::query('SELECT email FROM users WHERE email=:email', array(':email' => $email))) {
                            if (password_verify($password, DB::query('SELECT password FROM users WHERE email =:email', array(':email' => $email))[0]['password'])) {
                                $cstrong = True;
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username' => $username))[0]['id'];
                                $code = ($user_id * 4000);
                                DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));
                                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                                DB::query('INSERT INTO posts VALUES (\'\', :fname, :lname, \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\',\'\', \'\', :userid, NOW(),\'\',\'\',\'\',\'\', :university, \'\',\'\',\'\')', array(":fname" => $firstname, ":lname" => $lastname, ':userid' => $user_id, ':university' => $university));
                                DB::query('INSERT INTO verification VALUES (\'\', :user_id, 0, :code)', array(':code' => $code, ':user_id' => $user_id));
                                $smtp_details = array("account" => "noreply@varsitycareershub.co.uk", "pass" => "Nephthys60");
                                $from_name = "VCH Team";
                                $subject = "VCH | Verify Account";
                                $to = array($email);
                                $message1 = '<html><p>Dear ' . $firstname . ',</p><br/><p> Thank you for signing up to the Varsity Careers database. This email is to confirm that your email is correct. </p><br/><br/><strong><p>To validate your email address and get your account online, click <a href="https://www.varsitycareershub.co.uk/verified.php?id=' . $code;
                                if (isset($_POST['refCode'])) {
                                    $message1 .= "&ref=" . $_POST['refCode'];
                                } else {
                                    
                                }
                                $message1 .= '">here</a>. If you did not sign up to the database then please get in touch <a href="https://www.varsitycareershub.co.uk/contact-us.php">here</a>. </p></strong><br/><p>Thank you,</p><br/><p>Varsity Careers Hub Team</p></html>'; 

                                mailer_man($smtp_details, $from_name, $subject, $message1, $to);
                            }
                            $_SESSION['flash'] = "<b class='text-success'>Add Your Information<b>";
                            header("Location: add-doc1.php");
                        }
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
            if ($progress) {
                $message = "Invalid characters in one of your names";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    
<?php
    $title = "Signup";
    include_once "components/header.php";
?>

<body>
    <?php
        include_once "components/navbar.php";
    ?>
    <!--/banner_info-->
    <div class="banner_inner_con">
    </div>
    <?php
        include_once "components/sub_header.php";
    ?>
    <!--//banner_info-->
    <!-- /inner_content -->
    <div class="banner_bottom">
        <div class="container">
                <div class="tittle_head">
                <h3 class="tittle three">Sign Up <span>Now </span></h3>
            </div>
            <div class="inner_sec_info">
                <div class="signin-form">
                    <div class="login-form-rec">
                        <form onsubmit="return return check_form(event);" method="POST">
                            <input type='hidden' name='refCode' value='<?php echo (isset($ref)) ? $ref : ''; ?>'/>
                            <input type="text" name="fname" placeholder="First Name" required="">
                            <input type="text" name="lname" placeholder="Last Name" required="">
                            <input type="email" name="email" placeholder="Email" value="<?php
                                if (isset($_POST["email"])) {
                                    echo $_POST["email"];
                                }
                            ?>" required="">
                            <input type="password" name="password" id="password1" placeholder="Password (must be longer than 6 characters)" required="">
                            <input type="password" name="passwordC" id="password2" placeholder="Confirm Password" required="">
                            <div class="form-group">    <label style="font-size:12px;text-align:left"class="form-check-label" for="formCheck-1">
                            If you are a graduate then use your old university email and we will check and verify your account for you. 
                            </label> </div>
                            <div class="form-group"><label style="color:red"><?php echo $message ?></label></div><br />
                            
                            <label style="font-size:12px;text-align:left;" class="form-check-label" for="formCheck-1">
                            <input type="checkbox" style="display:inline-block;text-align:left;" required> 
                            <b>Accept Our T&amp;Cs</b><br/>I agree to Varsity Careers Hub's <a target="_blank" href="../TermsofUse.pdf">Terms of Use</a> and particularly to VCH's <a target="_blank" href="../Privacypolicy.pdf">Privacy Policy</a></label>
                            <br/><br/>
                            <label style="font-size:12px;text-align:left"class="form-check-label" for="formCheck-1">
                            <input type="checkbox" style="display:inline-block;text-align:left"required> 
                            <b>Allow Employers to contact you and to view your CV and Personal data</b><br/>
                            I consent to my personal information and CV being used and shared by Varsity Careers Hub to match me with career opportunities and to be contacted either by Varsity Careers Hub or potential employers, please find full details in the Terms of Use.   </label>
                            <br/><br/>
                            <label style="font-size:12px;text-align:left"class="form-check-label" for="formCheck-1">
                            <input type="checkbox" style="display:inline-block; "required> <b>Allow Varsity Careers Hub to contact you</b><br/>I consent to receive event invites, employers news , Varsity Careers Hub updates and handy hints to help me along my career journey </label>
                            <br/><br/>
                            <input type="submit" value="Sign Up">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        include_once "components/footer.php";
    ?>
    
    <!-- js -->
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- start-smoth-scrolling -->
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 900);
            });
        });
    </script>
    <!-- start-smoth-scrolling -->

    <script>
        $('ul.dropdown-menu li').hover(function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });
    </script>
    <!-- password-script -->
    <script type="text/javascript">
        window.onload = function () {
            document.getElementById("password1").onchange = validatePassword;
            document.getElementById("password2").onchange = validatePassword;
        }

        function validatePassword() {
            var pass2 = document.getElementById("password2").value;
            var pass1 = document.getElementById("password1").value;
            if (pass1 != pass2)
                document.getElementById("password2").setCustomValidity("Passwords Don't Match");
            else
                document.getElementById("password2").setCustomValidity('');
            //empty string means no validation error
        }
    </script>
    <!-- //password-script -->
    <script type="text/javascript">
        $(document).ready(function () {
            /*
                                    var defaults = {
                                        containerID: 'toTop', // fading element id
                                        containerHoverID: 'toTopHover', // fading element hover id
                                        scrollSpeed: 1200,
                                        easingType: 'linear' 
                                    };
                                    */

            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
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

        function email_check() {
            if ($('#email').val().search('.ox.ac.uk') == -1 && $('#email').val().search('.cam.ac.uk') == -1 && $('#email').val().search('durham.ac.uk') == -1 && $('#email').val().search('imperial.ac.uk') == -1 && $('#email').val().search('lse.ac.uk') == -1 && $('#email').val().search('ucl.ac.uk') == -1) {
                $('#email_erroor').text('Please sign up with your university email address.');
                return false;
            } else {
                return true;
            }
        }
    </script>

    <a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
</body>

</html>

