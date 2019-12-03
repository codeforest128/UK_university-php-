<?php
    include_once "../classes/DB.php";
?>

<!DOCTYPE html>
<html>
<?php
    $title = "Our Team";
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
	<!-- news 
	<div class="news-main">
				<div class="col-md-4 banner_bottom_left">
					<div class="banner_bottom_pos">
						<div class="banner_bottom_pos_grid">
							<div class="col-xs-3 banner_bottom_grid_left">
								<div class="banner_bottom_grid_left_grid">
									<span class="fa fa-laptop" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-xs-9 banner_bottom_grid_right">
								<h4>Digital Solutions</h4>
								<p>Lorem Ipsum is simply text the printing and typesetting standard industry.</p>

							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
				<div class="col-md-4 banner_bottom_left">
					<div class="banner_bottom_pos">
						<div class="banner_bottom_pos_grid">
							<div class="col-xs-3 banner_bottom_grid_left">
								<div class="banner_bottom_grid_left_grid">
									<span class="fa fa-pencil-square-o" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-xs-9 banner_bottom_grid_right">
								<h4>Live Website Builder</h4>
								<p>Lorem Ipsum is simply text the printing and typesetting standard industry.</p>

							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
				<div class="col-md-4 banner_bottom_left">
					<div class="banner_bottom_pos">
						<div class="banner_bottom_pos_grid">
							<div class="col-xs-3 banner_bottom_grid_left">
								<div class="banner_bottom_grid_left_grid">
									<span class="fa fa-newspaper-o" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-xs-9 banner_bottom_grid_right">
								<h4>Creative Strategy</h4>
								<p>Lorem Ipsum is simply text the printing and typesetting standard industry.</p>

							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	banner_info-->
	<!--/ab-->

	
	<!--//what-->
		<!-- /team -->
		<div class="banner_bottom proj" style="padding-top: 3em;">
			<div class="container">
				<h3 class="tittle">Team</h3>
				<p style="padding-bottom: 0;">VCH has developed an extensive network of students from all of our universities to help spread the word and develop the platform.</p>
				<div class="inner_sec_info">
				<ul id="sel-options" class="portfolio-categ filter">
					<li class="port-filter active" id="sel-all">
						<a onclick="select_tm('all')">All</a>
					</li>
					<li class="cat-item-1" id="sel-ox">
						<a onclick="select_tm('ox')">Oxford</a>
					</li>
					<li class="cat-item-2" id="sel-cam">
						<a onclick="select_tm('cam')">Cambridge</a>
					</li>
					<li class="cat-item-3" id="sel-dur">
						<a onclick="select_tm('dur')">Durham</a>
					</li>
					<li class="cat-item-4" id="sel-imp">
						<a onclick="select_tm('imp')">Imperial</a>
					</li>
				</ul>
				<?php
				    $sql = "SELECT `firstname`, `lastname`, `university`, `position`, `photo_url` FROM `rep_network`";
				    $team = DB::query($sql, null);
				    foreach ($team as $member) {
				        switch ($member["university"]) {
				            case "Cambridge":
				                $uni_code = "C";
				                $uni_name = "CAMBRIDGE";
				                break;
				            case "Durham":
				                $uni_code = "D";
				                $uni_name = "DURHAM";
				                break;
				            case "Imperial":
				                $uni_code = "I";
				                $uni_name = "IMPERIAL";
				                break;
				            default:
				                $uni_code = "O";
				                $uni_name = "OXFORD";
				        }
				        $html = "<div class='col-md-3 team_grid_info'>" .
				                    "<div class='uni-id uni-id-" . $uni_code . "'>" . $uni_name . "</div>" .
				                    "<img src='resources/och_team_photos/" . $member["photo_url"] . "' alt=' ' class='img-responsive1'/>" .
				                    "<h3>" . $member["firstname"] . " " . $member["lastname"] . "</h3>" .
				                    "<p>" . $member["position"] . "</p>" .
				                    "<div class='team_icons'>" .
				                        "<ul>" .
				                            " <!-- <li><a href='' class='facebook'><i class='fa fa-facebook' aria-hidden='true'></i></a></li>" .
				                            "<li><a href='' class='twitter'><i class='fa fa-twitter' aria-hidden='true'></i></a></li>" .
				                            "<li><a href='' class='dribble'><i class='fa fa-dribbble' aria-hidden='true'></i></a></li> -->" .
				                        "</ul>" .
				                    "</div>" .
				                "</div>";
				        echo $html;
				    }
				?>
					<div class="clearfix"></div>
				</div>
			</div>
		    <script src="scripts/teams.js"></script>
		</div>
	<!--/bottom-->
	</div>
	<div class="banner_bottom">
		<div class="container">
			<h3 class="tittle">How OCH developed its extensive network of student advisors and society representatives</h3>
			<div class="inner_sec_info">
				<div class="help_full">
					<div class="col-md-6 banner_bottom_left">
						<h4>How we have established ourselves as the go-to site for all grad opportunities</h4>
						<p>This will be the text from the blog article that callum will write.</p>
						<div class="ab_button">
							<a class="btn btn-primary btn-lg hvr-underline-from-left" href="single.html" role="button">Read More </a>
						</div>
					</div>
					<div class="col-md-6 banner_bottom_grid help">
						<img src="images/Employers_photo_of_students.jpg" alt=" " class="img-responsive">
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!--//bottom-->

    <?php
        include_once "components/footer.php";
    ?>
    
	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script>
		$('ul.dropdown-menu li').hover(function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});
	</script>
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