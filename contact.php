<?php
    include_once "../classes/DB.php";
    
    # Process contact form
    
    if (isset($_POST["name"]) && isset($_POST["email"])) {
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = strip_tags($_POST["subject"]);
        $message = nl2br(strip_tags($_POST["message"]));
        
        $to = array("team@varsitycareershub.co.uk");
        $reply = $email;
        $from_name = "Enquiry | " . $name;
        
        internal_mailer_man_and_reply($from_name, $subject, $message, $to, $reply);
    }
?>
<!DOCTYPE html>
<html>
<?php
    $title = "Contact Us";
    include_once "components/header.php";
?>
<body>
    <?php
        include_once "components/navbar.php";
    ?>
	<!--/banner_info-->
	<?php
	    //include_once "components/sub_header.php";
    ?>
	<!--//banner_info-->
	<!-- /inner_content -->
<div class="banner_bottom">
		<div class="container">
			<div class="mail_form">
				<h3 class="tittle">Send Us a Message</h3>
				<div style="margin-top: 2em;">
			    <p>If you have any questions regarding using the platform as a candidate, employer or just want to know more then please get in touch. We love hearing success stories too, if you are successfully employed through the platform and notify us then we’ll send you a bottle of champagne to celebrate! We always reply within 24 hours.</p>
			    </div>
				<div class="inner_sec_info">
					<form action="#" method="post">
						<span class="input input--chisato">
						<input class="input__field input__field--chisato" name="name" type="text" id="input-13" placeholder=" " required="" />
						<label class="input__label input__label--chisato" for="input-13">
							<span class="input__label-content input__label-content--chisato" data-content="Name">Name</span>
						</label>
						</span>
						<span class="input input--chisato">
						<input class="input__field input__field--chisato" name="email" type="email" id="input-14" placeholder=" " required="" />
						<label class="input__label input__label--chisato" for="input-14">
							<span class="input__label-content input__label-content--chisato" data-content="Email">Email</span>
						</label>
						</span>
						<span class="input input--chisato">
						<input class="input__field input__field--chisato" name="subject" type="text" id="input-15" placeholder=" " required="" />
						<label class="input__label input__label--chisato" for="input-15">
							<span class="input__label-content input__label-content--chisato" data-content="Subject">Subject</span>
						</label>
						</span>
						<textarea name="message" placeholder="Your comment here..." required=""></textarea>
						<input type="submit" value="Submit">
					</form>
				</div>
			</div>
			<div class="inner_sec_info">
           	    <div class="col-md-8 map">
				    <iframe width="100%" height="600" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=Oxford+(OCH)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="contact-map"></iframe>
			    </div>
			    <script src="scripts/contact_map.js"></script>
			    <div class="col-md-4 contact_grids_info">
				    <div class="contact_grid" onclick="change_map_focus('ox')">
					    <div class="contact_grid_right">
    					    <h4>Oxford Student Director</h4>
	    					<p>Ruby Vesey</p>
    	    			    <a href="mailto:ruby@varsitycareershub.co.uk">ruby@varsitycareershub.co.uk</a>
	    	    		</div>
		    	    </div>
    			    <div class="contact_grid" onclick="change_map_focus('dur')">
	    				<div class="contact_grid_right">
		    		    	<h4>Durham Student Director</h4>
			    		    <p>India Palmer-Tomkinson</p>
    	    			    <a href="mailto:india@varsitycareershub.co.uk">india@varsitycareershub.co.uk</a>
					    </div>
    				</div>
    				 <div class="contact_grid" onclick="change_map_focus('cam')">
	    				<div class="contact_grid_right">
		    		    	<h4>Cambridge University Director</h4>
			    		    <p>Appointed - TBC</p>
					    </div>
    				</div>
    				<div class="contact_grid" onclick="change_map_focus('ucl')">
	    				<div class="contact_grid_right">
		    		    	<h4>UCL Student Director</h4>
			    		    <p>Oli Ng</p>
    	    			    <a href="mailto:oli@varsitycareershub.co.uk">oli@varsitycareershub.co.uk</a>
					    </div>
    				</div>
	    			<div class="contact_grid" onclick="change_map_focus('imp')">
		    			<div class="contact_grid_right">
	    	    			<h4>Imperial Student Director</h4>
    			    		<p>Ahana Banerjee</p>
    	    			    <a href="mailto:ahana@varsitycareershub.co.uk">ahana@varsitycareershub.co.uk</a>
			    	    </div>
			        </div>
    				<div class="clearfix"></div>
	    		</div>
    	    	<div class="clearfix"></div>
			</div>
			<div class="clearfix"> </div>
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

	<a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>



</body>

</html>

