<div class="top_header" id="home">
	<!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="nav_top_fx">
			<div class="navbar-header" style="width: fit-content;">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<div class="logo">
				    <a href="index.php">
					    <img src="images/logo.png" height="122%" >
					    <img src="images/beta_icon.png" height="80%" >
				    </a>
				</div>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav nav-right">
					<li <?php if($title == "Students") { ?>class="active"<?php } ?>><a href="index.php">Students</a></li>
					<li <?php if($title == "Employers") { ?>class="active"<?php } ?>><a href="employers.php">Employers</a></li>
			        <li <?php if($title == "Blog") { ?>class="active"<?php } ?>><a href="blog.php">Blog</a></li>
			        <li <?php if($title == "Our Mission") { ?>class="active"<?php } ?>><a href="mission.php">About Us</a></li>

			        
			<!--		<li class="dropdown<?php
					    if ($title == "Our Mission" || $title == "Our Team" || $title == "Our Societies") {
					        echo " active";
					    }
					?>">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About us<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li <?php if($title == "Our Mission") { ?>class="active"<?php } ?>><a href="mission.php">Our Mission</a></li>
					<!--		<li <?php if($title == "Our Team") { ?>class="active"<?php } ?>><a href="team.php">Our Team</a></li> -->
					<!--		<li <?php if($title == "Our Societies") { ?>class="active"<?php } ?>><a href="societies.php">Our Societies</a></li> -->
				<!--		</ul>
					</li> -->
					<li <?php if($title == "Contact Us") { ?>class="active"<?php } ?>><a href="contact.php">Contact</a></li>
				    <li <?php if($title == "Login" || $title == "Signup") { ?>class="active"<?php } ?>><a class="request" href="login.php" style="transform: translate(0, -1px);background-color:#04003c;color:white">Login /Sign Up</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>
</div>
<div class="top_header" id="nav_fix">
    <div class="navbar navbar-default" style="margin-bottom: 0;">
        <div class="nav_top_fx">
            <div class="navbar-header">
                <div class="logo">
                    <img src="images/logo.png" height="122%"/>
                </div>
            </div>
            <div class="navbar-collapse collapse" style="padding: 0;">
                <div class="nav_right_top">
					<ul class="nav navbar-nav">
						<li><a href="#">Students</a></li>
						<li><a href="#">Employers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">About us</a></li>
						<li><a href="#">Contact</a></li>
						<li><a class="request" href="#" style="transform: translate(0, -1px)">Login /Sign Up</a></li>
					</ul>
                </div>
            </div>
        </div>
    </div>
</div>