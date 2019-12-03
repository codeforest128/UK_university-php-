<?php
    include_once "../classes/DB.php";
?>
<!DOCTYPE html>
<html>
<?php
    $title = "Blog";
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
	<!--/ab-->
	<div class="banner_bottom">
		<div class="container">
			<h3 class="tittle">Our news</h3>
			<p>Keep up to date with the latest VCH news and career advice through our blog page. We also post articles with application tips and insights on specific industries. All content is produced by our team or by industry experts and external writers writing on our behalf.</p>
			<div class="inner_sec_info">
				<!--/projects-->
				<!--<ul class="portfolio-categ filter">
					<li class="port-filter all active">
						<a href="#">All</a>
					</li>
					<li class="cat-item-1">
						<a href="#" title="Category 1">Student Applications</a>
					</li>
					<li class="cat-item-2">
						<a href="#" title="Category 2">Employers</a>
					</li>
					<li class="cat-item-3">
						<a href="#" title="Category 3">VCH News</a>
					</li>
					<li class="cat-item-4">
						<a href="#" title="Category 4">CV advice</a>
					</li>
				</ul> -->
				<ul class="portfolio-area">
                <?php
                    // Fetch blog info
                    echo date();
                    $sql = "SELECT `title`, `brief_descr`, `scheduled_date`, `img_url`, `tags`, `id` "
                         . "FROM `blogs` "
                         . "WHERE `scheduled_date` <= CURRENT_DATE() "
                         . "ORDER BY `scheduled_date` DESC";
                    $blog_details = DB::query($sql, null);
                    foreach ($blog_details as $blog) {
                        $blog_html ="<li class='portfolio-item2'>" .
                                        "<div>" .
                                            "<span class='image-block block2 img-hover'>" .
                                                "<a class='image-zoom' href='blogpost.php?bid=" . $blog["id"] . "'>" .
                                                    "<img src='resources/blog_photos/" . $blog["img_url"] . "' class='img-responsive' alt='Conceit'>" .
                                                    "<div class='port-info'>" .
                                                        "<h5>" . $blog["title"] . "</h5>" .
                                                        "<p>" . $blog["brief_descr"] . "</p>" .
                                                    "</div>" .
                                                "</a>" .
                                            "</span>" .
                                        "</div>" .
                                    "</li>";
                        echo $blog_html;
                    }
                ?>
					<div class="clearfix"></div>
				</ul>
				<!--end portfolio-area -->
			</div>
		</div>
		<!--//projects-->
	</div>
	<!--//bottom-->

    <?php
        include_once "components/footer.php";
    ?>
	
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script>
		$('ul.dropdown-menu li').hover(function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});
	</script>

	<!-- js -->
	<!-- Smooth-Scrolling-JavaScript -->
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll, .navbar li a, .footer li a").click(function (event) {
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<!-- //Smooth-Scrolling-JavaScript -->
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
	<!-- jQuery-Photo-filter-lightbox-Gallery-plugin -->
	<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script src="js/jquery.quicksand.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
	<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<!-- //jQuery-Photo-filter-lightbox-Gallery-plugin -->
</body>

</html>