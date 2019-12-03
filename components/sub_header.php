<div class="services-breadcrumb">
	<div class="inner_breadcrumb">
	    <ul id="sub_header_ul" class="short">
	    <?php
	        if ($title == "Our Mission") {
	    ?>
	        <li>Home<span>|</span></li>
	        <li><a href="mission.php">About Us</a><span></a></li>
	    <?php
	        } else if ($title == "Our Team") {
        ?>
            <li><a href="mission.php">Our Mission</a><span>|</span></li>
	        <li>Our Team<span>|</span></li>
	        <li><a href="societies.php">Our Societies</a></li>
        <?php
	        } else if ($title == "Our Societies") {
	    ?>
	        <li><a href="mission.php">Our Mission</a><span>|</span></li>
	        <li><a href="team.php">Our Team</a><span>|</span></li>
	        <li>Our Societies</li>
	    <?php
	        } else {
	    ?>
	        <li><a href="index.php">Home</a><span>|</span></li>
			<li><?php echo $title; ?></li>
	    <?php
	        }
	    ?>
	    </ul>
	    <script src="scripts/sub_header.js"></script>
	</div>
</div>