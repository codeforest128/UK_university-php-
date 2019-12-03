<!DOCTYPE html>
<html>

<?php 
    include_once "../classes/DB.php";

    $modal = "";
						
    if (isset($_POST["join"])) {
        
        $central_role = isset($_POST["central_role"]) ? 1 : 0;
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $university = $_POST["university"];
        $college = $_POST["college"];
        $about = nl2br(strip_tags($_POST["about"]));
        $modal = '<div style="width:100%;height:auto;background-color:#00003c;font-size:24px; text-align:center; color:white;padding:25px; margin-bottom: 2em;"> Thanks for applying to VCH, we will be in touch to find out a bit more about you and we look forward to meeting you soon!</div>';
        
        DB::query('INSERT INTO sap_applications VALUES (\'\', :name, :email, :university, :college, :about, :central)', array(':name' => $name, ':email' => $email, ':university'=>$university, ':college'=>$college, ':about'=>$about, ':central' => $central_role));

        $to = array("team@varsitycareershub.co.uk");
        
        switch($university) {
            case "Durham University":
                array_push($to, "india@varsitycareershub.co.uk");
                array_push($to, "william@varsitycareershub.co.uk");
                break;
            case "UCL":
                array_push($to, "oli@varsitycareershub.co.uk");
                break;
            case "Imperial College London":
                array_push($to, "ahana@varsitycareershub.co.uk");
                break;
            case "Oxford University":
                array_push($to, "ruby@varsitycareershub.co.uk");
                break;
            case "Cambridge University":
                array_push($to, "constantinos@varsitycareershub.co.uk");
                break;
        }
        
        $pretty_central_role = ($central_role === 1) ? "Yes" : "No";
        
        $from_name = $name;
        $subject = "Student Advisor Application";
        $message = "<style>div p {display: inline-block; width: 20%}</style><div><p>Name:</p><p>".$name.'</p><br><p>Email:</p><p>'.$email.'</p><br><p>University:</p><p>'.$university.'</p><br><p>College:</p><p>'.$college.'</p><br><p>Central role:</p><p>'.$pretty_central_role.'</p><br/><p>About:</p>'.$about.'</div>';
        $reply = $email;
        
        internal_mailer_man_and_reply($from_name, $subject, $message, $to, $reply);
    
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
"Times New Roman";color:#1B1B1B;letter-spacing:1.5pt;mso-fareast-language:EN-GB'>VCH
needs you!<o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><b><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>Overview</span></b><span style='font-size:9.5pt;
font-family:"Arial",sans-serif;mso-fareast-font-family:"Times New Roman";
color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>Varsity Careers Hub (VCH) is a new careers database that has been created by students to connect top companies with students from top UK universities. Signing up takes just a few minutes, unlike the lengthy application forms that are normally required for graduate jobs.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>We are building a network of Student Advisors across Oxford, Cambridge, Durham, Imperial, UCL and LSE. The Student Representatives will promote VCH across their universities, through targeting societies, friends, and people on their course. Alongside this, they will have the chance to influence the company’s direction, providing a valuable experience working with a successful start-up company.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><b><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>What does the role involve?</span></b><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>1.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>Promoting VCH among your chosen student group, e.g. by<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:7.5pt;
margin-left:72.0pt;text-indent:-18.0pt;line-height:22.8pt;background:white'><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>a.</span><span
style='font-size:7.0pt;font-family:"Times New Roman",serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>lobbying your society’s committee to promote VCH and email their members,<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:7.5pt;
margin-left:72.0pt;text-indent:-18.0pt;line-height:22.8pt;background:white'><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>b.</span><span
style='font-size:7.0pt;font-family:"Times New Roman",serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>Facebook,LinkedInand Instagram marketing, and<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:7.5pt;
margin-left:72.0pt;text-indent:-18.0pt;line-height:22.8pt;background:white'><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>c.</span><span
style='font-size:7.0pt;font-family:"Times New Roman",serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>by helping to organise on-campus events for both VCH and for clients.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>2.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>Provide
advice and support to Companies using the VCH platform, allowing you to develop
unique relationships with employers within industries that interest you<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>3.<span style='mso-spacerun:yes'>  </span>The
potential to get more involved with the central running and progression of the
venture<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><b><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>What do you get from working with us?</span></b><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>1.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>Direct contact with the recruitment teams at top firms.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>2.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>Experience working with a technology start-up.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>3.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>A boost on the VCH database, improving your profile’s rank, resulting in more offers, interviews, and invitations to apply from employers.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>4.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>The job title of VCH Student Representative for your CV.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>5.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>The chance to work alongside other career-driven students as part of the wider VCH network.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;text-indent:-18.0pt;line-height:
22.8pt;background:white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;
mso-fareast-font-family:"Times New Roman";color:#04003C;letter-spacing:.75pt;
mso-fareast-language:EN-GB'>6.</span><span style='font-size:7.0pt;font-family:
"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";color:#04003C;
letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>If all of that was not enough, there will be regular marketing competitions for Student Representatives, not to mention lots of merchandise and other rewards on offer!<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt;line-height:22.8pt;background:
white'><span style='font-size:9.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#04003C;letter-spacing:.75pt;mso-fareast-language:EN-GB'>&nbsp;<o:p></o:p></span></p>

<p class=MsoNormal align=center style='margin-bottom:8.4pt;text-align:center;
line-height:normal;mso-outline-level:3;background:white'><b><span
style='font-size:32.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
"Times New Roman";color:#1B1B1B;letter-spacing:1.5pt;mso-fareast-language:EN-GB'>If this interests you, apply below for a chance to get exposure to top firms and experience at a rapidly-expanding start-up!<o:p></o:p></span></b></p>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

</div>

</body>
</html>

						

			</div>
			<div class="inner_sec_info">
				<div class="signin-form">
					<div class="login-form-rec">
<form  method="post">
							<input type="text" name="name" placeholder="Name" required>
							<input type="email" name="email" placeholder="Email" required>
                            <select name="university" >
                                <option disabled selected>Select</option>
                                <option value="Oxford University">Oxford University</option>
                                <option value="Cambridge University">Cambridge University</option>
                                <option value="Durham University">Durham University</option>
                                <option value="UCL">UCL</option>
                                <option value="Imperial College London">Imperial College London</option>
                                <option value="LSE">LSE</option>
                                
                                
                            </select>        
                            <input type="text" name="college" placeholder="College, subject or society" required>
							<label style="text-align: left; width: 100%;" class="form-check-label"><input type="checkbox" name="central_role"> Interested in a central role at VCH?</label>
							<textarea type="text" name="about" placeholder="Tell us a bit more about yourself, we only need to know the essentials so about 25 words!" required></textarea>
							<label style="font-size:12px;text-align:left;" class="form-check-label" for="formCheck-1">
							<input type="checkbox" style="display:inline-block;text-align:left;" required> 
							<b>Accept Our T & CS</b><br/>I agree to the Varsity Careers Hub <a target="_blank" href="../TermsofUse.pdf">Terms of Use</a> and particularly to the VCH <a target="_blank" href="../Privacypolicy.pdf">Privacy Policy</a></label>
							<br/><br/>
     			    		
							
							
							<input type="submit" name="join" value="Join">
						</form>					
					</div>

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

