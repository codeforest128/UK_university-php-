<!DOCTYPE html>
<html>
    <?php
        include_once "../classes/DB.php";
        include_once "../classes/login.php";
        
        if (Login::isLoggedIn()) {
            header("Location: account.php");
            exit;
        }
        
        $message = "";
        if (isset($_POST["email"])) {
            echo "Triggered";
            $username = $_POST["email"];
            $password = $_POST["password"];
            if (DB::query('SELECT email FROM users WHERE email=:username', array(':username'=>$username))) {
                if (password_verify($password, DB::query('SELECT password FROM users WHERE email=:username', array(':username'=>$username))[0]['password'])) {
                        header ("Location: account.php");
                        $cstrong = True;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $user_id = DB::query('SELECT id FROM users WHERE email=:username', array(':username'=>$username))[0]['id'];
                        DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                } else {
                    $message = 'Incorrect Password!';
                }
            } else {
                $message = 'User not registered!';
            }
        }
        
        $title = "Login";
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
								<input type="submit" value="login">
							</div>
						</form>
					</div>
					<div class="login-social-grids">
						<ul>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-rss"></i></a></li>
						</ul>
					</div>
					<p><a href="signup.php"> Don't have an account?</a></p>
					<p><a href="forgot-pass.php"> Forgotten your password?</a></p>
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
	<!-- stats -->
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.countup.js"></script>
	<script>
		$('.counter').countUp();
	</script>
	<!-- //stats -->
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

	<a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>



</body>

</html>