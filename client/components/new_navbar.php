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
					    <img src="../images/logo.png" height="100%">
					    <img src="../images/beta_icon.png" height="80%" style="margin-bottom:10px;" >
				    </a>
				</div>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav nav-right">
					<li <?php if($page_title == "Analytics") { ?>class="active"<?php } ?>><a href="feedback.php"><font color="red">Give us feedback!</font></a></li>
					<li <?php if($page_title == "Dashboard") { ?>class="active"<?php } ?>><a href="dashboard.php">dashboard</a></li>
					<li <?php if($page_title == "Help") { ?>class="active"<?php } ?>><a href="help.php">Help</a></li>
					<li <?php if($page_title == "Database") { ?>class="active"<?php } ?>><a href="database.php">Database</a></li>
					<li <?php if($page_title == "Account") { ?>class="active"<?php } ?>><a href="account.php">My Account</a></li>
					<!-- <li <?php if($page_title == "Analytics") { ?>class="active"<?php } ?>><a href="analytics.php">Analytics</a></li> -->
				    <li><a class="request" href="logout.php" style="transform: translate(0, -1px)">Logout</a></li>
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
                    <img src="../images/logo.png" width="10%"/>
                </div>
            </div>
            <div class="navbar-collapse collapse" style="padding: 0;">
                <div class="nav_right_top">
					<ul class="nav navbar-nav">
					    <li><a href="#">Give us feedback!</a></li>
						<li><a href="#">Help</a></li>
						<li><a href="#">Database</a></li>
						<!-- <li><a href="#">Analytics</a></li> -->
                        <li><a href="#">My Account</a></li>
						<li><a class="request" href="#" style="transform: translate(0, -1px)">Logout</a></li>
					</ul>
                </div>
            </div>
        </div>
    </div>
</div>