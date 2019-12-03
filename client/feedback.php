<?php
    include_once "../../classes/DB.php";
    include_once "../../classes/Login.php";
    
    if (isset($_COOKIE['SNID'])) {
        
        # Get client id
        $token = $_COOKIE['SNID'];
        $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
        
        # Gather client details
        $sql = "SELECT company_name, contact_name, contact_email, account_manager_id FROM `client_details` WHERE `client_id`=:cid";
        $client_details = DB::query($sql, array(":cid" => $clientid))[0];
        
        # Gather account manager details
        $sql = "SELECT name, och_email, personal_email, begin_time, end_time FROM `client_account_managers` WHERE `id`=:amid";
        $am_details = DB::query($sql, array(":amid" => $client_details["account_manager_id"]))[0];
        
    } else {
        header("account.php");     
    }
    
    if (isset($_POST["subject"]) && isset($_POST["message"])) {
        
        # Gather message information
        $subject = $_POST["subject"];
        $message = nl2br(strip_tags($_POST["message"]));
        
        $to = array($am_details["och_email"]);
        if ($am_details["personal_email"] != "") {
               array_push($to, $am_details["personal_email"]);
        }
        
        $from = "Enquiry | " . $client_details["company_name"];
        $reply_to = $client_details["contact_email"];
        
        $message = "<h4>Enquiry from " . $client_details["contact_name"] . " at " . $client_details["company_name"] . "</h4><br/>" . $message;
        
      //internal_mailer_man_and_reply($from, $subject, $message,array("nvidia1288@mailinator.com"), $reply_to);

        $to = array('team@varsitycareershub.co.uk');

        $smtp_details = array("account" => "noreply@varsitycareershub.co.uk", "pass" => "GqpZ38s4");
         mailer_man_cc($smtp_details,"Feedback", $subject, $message,$to, $reply_to); 
    }
?>
<!DOCTYPE html>
<html>
<?php
    $page_title = "Help";
    include_once "components/header.php";
?>
<style>
    html {
        font-size: 90% !important;
    }
    .input__field--chisato,.mail_form textarea {
        background-color:#fff !important;
    }
</style>
<body>
    <?php
        include_once "components/new_navbar.php";
    ?>


  
  <div class="cd-faq__overlay" aria-hidden="true"></div>
</section>
<div class="banner_bottom" id="contact">
		<div class="container">
            <div class="mail_form">
	            <h3 class="tittle">Please give us feedback to support our development</h3>
        	    <div style="margin-top: 2em;">
	                <p>If you have any questions or ideas about how the platform could be better and what features you would like to see included please drop a very quick message to us here so that we can work on including these in the next release of the platform! It doesn't matter how off the wall or different from the current platform it is!<?php echo $am_details["name"]; ?>. We'll always reply within 24hrs.</p>
                </div>
    	        <div class="inner_sec_info">
	    	        <form action="" method="post">
	    	        	<input type="hidden" name="submit_feedback">
		        	    <!--<span class="input input--chisato">
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
	        		    </span>-->

	        		    <style type="text/css">
	        		    	
	        		    	/*-- effect --*/

.input {
	position: relative;
	z-index: 1;
	display: inline-block;
	max-width: 373px;
	width: calc(100% - 0em);
	vertical-align: top;
}

span.input.input--chisato:nth-child(2) {
	margin: 0 0.33em;
}

.input__field:invalid {
	position: relative;
	display: block;
	float: right;
	padding: 0.8em;
	width: 60%;
	border: none;
	border-radius: 0;
	background: #f0f0f0;
	color: #aaa;
	font-weight: 400;
	-webkit-appearance: none;
	/* for box shadows to show on iOS */
}

.input__field:focus {
	outline: none;
}

.input__label {
	display: inline-block;
	float: right;
	padding: 0 1em;
	width: 40%;
	color: #696969;
	font-weight: bold;
	font-size: 12px;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.input__label-content {
	position: relative;
	display: block;
	padding: 1.6em 0;
	width: 100%;
}

/* Chisato */

.input--chisato {
	padding-top: 1em;
}

.input__field--chisato:invalid {
	width: 100%;
	padding: 1em 0.5em;
	background: transparent;
	border: 2px solid #b5b5b5;
	color: #212121;
	-webkit-transition: border-color 0.25s;
	transition: border-color 0.25s;
	font-size: 14px;
}

.input__label--chisato {
	width: 100%;
	position: absolute;
	top: 0;
	text-align: left;
	overflow: hidden;
	padding: 0;
	pointer-events: none;
	-webkit-transform: translate3d(0, 3em, 0);
	transform: translate3d(0, 3em, 0);
}

.input__label-content--chisato {
	padding: 0 1em;
	font-weight: 400;
	color: #7d7b7b;
	font-family: 'Merriweather Sans', sans-serif;
	letter-spacing: 1px;
}

.input__label-content--chisato::after {
	content: attr(data-content);
	position: absolute;
	top: -200%;
	left: 0;
	color: #76daff;
	font-weight: 600;
}

.input__field--chisato:focus,
.input--filled .input__field--chisato {
	border-color: #76daff;
}

textarea:focus,textarea:valid{
	border-color: #76daff;
}

.input__field--chisato:focus+.input__label--chisato,
.input--filled .input__label--chisato {
	-webkit-animation: anim-chisato-1 0.25s forwards;
	animation: anim-chisato-1 0.25s forwards;
}

.input__field--chisato:focus+.input__label--chisato .input__label-content--chisato,
.input--filled .input__label-content--chisato {
	-webkit-animation: anim-chisato-2 0.25s forwards ease-in;
	animation: anim-chisato-2 0.25s forwards ease-in;
}

.input__field--chisato:valid,
.input--filled .input__field--chisato {
	border-color: #76daff;
}

.input__field--chisato:valid+.input__label--chisato,
.input--filled .input__label--chisato {
	-webkit-animation: anim-chisato-1 0.25s forwards;
	animation: anim-chisato-1 0.25s forwards;
}

.input__field--chisato:valid+.input__label--chisato .input__label-content--chisato,
.input--filled .input__label-content--chisato {
	-webkit-animation: anim-chisato-2 0.25s forwards ease-in;
	animation: anim-chisato-2 0.25s forwards ease-in;
}

@-webkit-keyframes anim-chisato-1 {
	0%,
	70% {
		-webkit-transform: translate3d(0, 3em, 0);
		transform: translate3d(0, 3em, 0);
	}
	71%,
	100% {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
	}
}

@-webkit-keyframes anim-chisato-2 {
	0% {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
	}
	70%,
	71% {
		-webkit-transform: translate3d(0, 125%, 0);
		transform: translate3d(0, 125%, 0);
		opacity: 0;
		-webkit-animation-timing-function: ease-out;
	}
	100% {
		color: transparent;
		-webkit-transform: translate3d(0, 200%, 0);
		transform: translate3d(0, 200%, 0);
	}
}

@keyframes anim-chisato-1 {
	0%,
	70% {
		-webkit-transform: translate3d(0, 3em, 0);
		transform: translate3d(0, 3em, 0);
	}
	71%,
	100% {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
	}
}

@keyframes anim-chisato-2 {
	0% {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
	}
	70%,
	71% {
		-webkit-transform: translate3d(0, 125%, 0);
		transform: translate3d(0, 125%, 0);
		opacity: 0;
		-webkit-animation-timing-function: ease-out;
	}
	100% {
		color: transparent;
		-webkit-transform: translate3d(0, 200%, 0);
		transform: translate3d(0, 200%, 0);
	}
}

	        		   

	        		    </style>

		            	<div class="input input--chisato">
		        	    	<input class="input__field input__field--chisato" name="subject" type="text" id="input-15" placeholder=" " required="" />
	        	    	    <label class="input__label input__label--chisato" for="input-15">
        			    	    <span class="input__label-content input__label-content--chisato" data-content="Subject">Subject</span>
        				    </label>
        	    		</div>
	    	    	    <textarea name="message" placeholder="Your comment here..." required=""></textarea>
    	    	        <input type="submit" value="Submit">
	                </form>
                </div>
            </div>
        </div>
    </div>
<script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="assets/js/main.js"></script> 
    <?php
        include_once "components/new_footer.php";
    ?>
</body>
</html>