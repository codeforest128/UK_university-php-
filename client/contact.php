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
        
        internal_mailer_man_and_reply($from, $subject, $message, $to, $reply_to);
    }

    $page_title = "Contact Us";
    include_once "components/header.php";
?>
<style>
    body {
        background: #f8f9fa;;
    }
</style>
<body>
    <?php
        include_once "components/new_navbar.php";
    ?>
    <div class="banner_bottom">
		<div class="container">
            <div class="mail_form">
	            <h3 class="tittle">Contact your account manager</h3>
        	    <div style="margin-top: 2em;">
	                <p>If you have any questions regarding using the platform as a candidate, employer or just want to know more then please get in touch. We love hearing success stories too, if you are successfully employed through the platform and notify us then we’ll send you a bottle of champagne to celebrate! We always reply within 24 hours.</p>
                </div>
    	        <div class="inner_sec_info">
	    	        <form action="#" method="post">
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
		            	<span class="input input--chisato">
		        	    	<input class="input__field input__field--chisato" name="subject" type="text" id="input-15" placeholder=" " required="" />
	        	    	    <label class="input__label input__label--chisato" for="input-15">
        			    	    <span class="input__label-content input__label-content--chisato" data-content="Subject">Subject</span>
        				    </label>
        	    		</span>
	    	    	    <textarea name="message" placeholder="Your comment here..." required=""></textarea>
    	    	        <input type="submit" value="Submit">
	                </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    include_once "components/new_footer.php";
?>