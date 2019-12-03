<?php
    include_once "../classes/DB.php";

    if(!isset($_GET["bid"])) {
        header("Location: index.php");
        exit;
    }
    
    $sql = "SELECT `title`, `body`, `scheduled_date`, `img_url`, `author`, `tags` "
         . "FROM `blogs` "
         . "WHERE id=:bid";
    $blog_det = DB::query($sql, array(":bid" => $_GET["bid"]))[0];
?>
<!DOCTYPE html>
<html>
    <?php
        $title = $blog_det["title"];
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
			<div class="col-md-9 technology-left">
				<div class="business">
					<div class=" blog-grid2">
						<img src="../../../resources/blog_photos/<?php echo $blog_det["img_url"]; ?>" class="img-responsive" alt="">
						<div class="blog-text">
							<h5 style="display: inline-block;"><?php echo $blog_det["title"]; ?></h5>
							<h5 style="float: right; display: inline-block;"><?php echo $blog_det["scheduled_date"]; ?></h5>
							<div><?php echo nl2br($blog_det["body"]); ?></div>
							<br/>
							<div style="float: right;">By <?php echo $blog_det["author"]; ?></div>
							<br/>
						</div>
					</div>
                </div>
            </div>

			<!-- technology-right -->
			<div class="col-md-3 technology-right-1">
				<div class="blo-top">
					<div class="tech-btm">
						<img src="images/banner1.jpg" class="img-responsive" alt="" />
					</div>
				</div>
				<div class="blo-top">
					<div class="tech-btm">
						<h4>Join our platform here</h4>
						<p>If you've decided to join the #ochmovement, sign up here and wait for the offers to role in</p>
						<div class="name">
							<form action="signup.php">
								
								<input type="email" name="Email" placeholder="Email" required="">
								<div class="button">

									<input type="submit" value="Sign Up">

								</div>
							</form>
						</div>

						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="blo-top1">
					<div class="tech-btm">
						<h4>Recent posts </h4>
						<?php 
						
						$blogs = DB::query('SELECT * FROM blogs LIMIT 5');
						
						foreach($blogs as $blog) {
						echo '<div class="blog-grids">
							<div class="blog-grid-left">
								<a href="single.html"><img src="../../../resources/blog_photos/'.$blog['img_url'].'" class="img-responsive" alt=""/></a>
							</div>
							<div class="blog-grid-right">

								<h5><a href="blogpost.php?bid='.$blog['id'].'">'.$blog['title'].'</a> </h5>
							</div>
							<div class="clearfix"> </div>
						</div>
						
						';
						
						} ?>
						
					
					</div>
				</div>

			</div>
			<div class="clearfix"></div>
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