<!DOCTYPE html>
<html>

<?php 
    include_once "../classes/DB.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $itd = ($id / 4000);
        $exists = DB::query('SELECT verified FROM verification WHERE code=:code', array(':code' => $id))[0]['verified'];
        if ($exists == 0) {
            DB::query('UPDATE verification SET verified="1" WHERE code=:code', array(':code' => $id));
            DB::query('UPDATE posts SET verified="1" WHERE user_id=:code', array(':code' => $itd));
            // Check if reference code is in use and update table if so
            if (isset($_GET['ref'])) {
                // Get current list of students who've used link
                $ref = $_GET['ref'];
                $cList = DB::query('SELECT stu_ids_verified FROM reference_codes WHERE code=:code', array(':code' => $ref))[0]['stu_ids_verified'];
                if (isset($cList)) {
                    $nList = substr($cList, 0, -1);
                    $nList .= ", " . $itd . "]";
                } else {
                    $nList = "[" . $itd . "]";
                }
                DB::query('UPDATE reference_codes SET stu_ids_verified=:nList WHERE code=:code', array(':nList' => $nList, ':code' => $ref));
            }
        }
    }
?>

<head>
	<title>Join VCH | VCH</title>
	<!--/tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Conceit Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--//tags -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- //for bootstrap working -->
	<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,300,300i,400,400i,500,500i,600,600i,700,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,600,600i,700" rel="stylesheet">
</head>

<body>
<div class="top_header" id="home">
	<!-- Fixed navbar -->
    <?php
        include_once "components/navbar.php";
    ?>
	</div>
	<!--/banner_info-->
	<div class="banner_inner_con">

	</div>
	<div class="services-breadcrumb">
		<div class="inner_breadcrumb">

			<ul class="short">
				<li><a href="index.html">Home</a><span>|</span></li>
				<li>Sign up</li>
			</ul>
		</div>
	</div>
	<!--//banner_info-->
	<!-- /inner_content -->
<div class="banner_bottom">
		<div class="container">
				<div class="tittle_head">
				    <?php echo($modal); ?>

			<body lang=EN-GB style='tab-interval:36.0pt'>

<div class=WordSection1>

<p class=MsoNormal align=center style='margin-bottom:8.4pt;text-align:center;
line-height:normal;mso-outline-level:3;background:white'><b><span
style='font-size:32.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#1B1B1B;letter-spacing:1.5pt;mso-fareast-language:EN-GB'>Thank you for verifying your account, now sit back and wait for the offers to roll in!<o:p></o:p></span></b></p>


				</div>
			</div>
		</div>
	</div>

	<!-- footer -->
			    <?php
        include_once "components/footer.php";
    ?>
	<!-- //footer -->
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

