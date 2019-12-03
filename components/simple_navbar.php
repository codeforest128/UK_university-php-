<div class="top_header" id="home">
	<!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="nav_top_fx">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<div class="logo">
					<img src="images/logo.png" height="122%">
				</div>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<div class="nav_right_top">
					<ul class="nav navbar-nav navbar-right">
			            <?php
			                if ($title != "Add Details") {
			            ?>
						<li <?php if($title == "Account") { ?>class="active"<?php } ?>><a href="account.php">My Account</a></li>
						<li><a class="request" href="logout.php" style="transform: translate(0, -1px);">Logout</a></li>
						<?php
			                }
			            ?>
					</ul>
				</div>
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
                        <?php 
                            if ($title != "Add Details") {
                        ?>  
                        <li><a href="#">My Account</a></li>
                        <li><a class="request" href="#">Logout</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>