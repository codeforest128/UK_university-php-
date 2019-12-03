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
    <section class="cd-faq js-cd-faq container max-width-md margin-top-lg margin-bottom-lg">
	<ul class="cd-faq__categories">
		<li><a class="cd-faq__category cd-faq__category-selected truncate" href="#basics">Basics</a></li>
		<li><a class="cd-faq__category truncate" href="#mobile">Mobile</a></li>
		<li><a class="cd-faq__category truncate" href="#account">Account</a></li>
		<li><a class="cd-faq__category truncate" href="#payments">Data Access</a></li>
		<li><a class="cd-faq__category truncate" href="#contact">Contact</a></li> 
	</ul> <!-- cd-faq__categories -->

	<div class="cd-faq__items">
		<ul id="basics" class="cd-faq__group">
			<li class="cd-faq__title"><h2>Basics</h2></li>
			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How do I change my password?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
          <div class="textleft">To change your password, simply click on change password in the bottom left hand corner of the account page. You will be asked to add your old password and the that you would like to change it to. </div>
          <div class="textright"><img src="assets/images/changepassword.png"></div>
          </div>
				</div> <!-- cd-faq__content -->
			</li>

			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How do I log in?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
                   <div class="textleft">To log in, navigate to the page <a href="https://varsitycareershub.co.uk">www.varsitycareershub.co.uk</a> and then add your email and your unique password. Then click on Login as Client and you will be directed to your account. Passwords are case sensitive so ensure that your password is correct.</div>
				          <div class="textright"><img src="assets/images/login.png"></div>

				</div> <!-- cd-faq__content -->
			</li>

			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How much does the service cost?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
The service is totally free for students and clients. 
          </div>
				</div> <!-- cd-faq__content -->
			</li>

			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How can I delete my account?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
			To delete your account, contact your student advisor who's details you can find in your welcome pack. Alternatively, you can email our Tech team at <a href="support@varsitycareershub.co.uk">support@varsitycareershub.co.uk</a> and they can take care of your request.
          </div>
				</div> <!-- cd-faq__content -->
			</li>
		</ul> <!-- cd-faq__group -->

		<ul id="mobile" class="cd-faq__group">
			<li class="cd-faq__title"><h2>Mobile</h2></li>
			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>Why can't I access the platform on my phone?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
Right now the platform is only available on desktops as the client platform is only in Beta Version.          </div>
				</div> <!-- cd-faq__content -->
			</li>

			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>Will I be able to access the platform from my phone?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
We hope to be able to launch our mobile compatible version in October 2019, along with lots of other new, useful features.          </div>
				</div> <!-- cd-faq__content -->
			</li>

			
		</ul> <!-- cd-faq__group -->

		<ul id="account" class="cd-faq__group">
			<li class="cd-faq__title"><h2>Account</h2></li>
			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How do I change my password?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
<div class="textleft">To change your password, simply click on change password in the bottom left hand corner of the account page. You will be asked to add your old password and the that you would like to change it to. </div>
          <div class="textright"><img src="assets/images/changepassword.png"></div>          </div>
				</div> <!-- cd-faq__content -->
			</li>

			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How do I delete my account?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
			To delete your account, contact your student advisor who's details you can find in your welcome pack. Alternatively, you can email our Tech team at <a href="support@varsitycareershub.co.uk">support@varsitycareershub.co.uk</a> and they can take care of your request.
          </div>
				</div> <!-- cd-faq__content -->
			</li>


			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>I forgot my password. How do I reset it?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
If you have forgotten your password then you should contact our Tech team at <a href="support@varsitycareershub.co.uk">support@varsitycareershub.co.uk</a> and they can take care of your request.          </div>
				</div> <!-- cd-faq__content -->
			</li>
		</ul> <!-- cd-faq__group -->

		<ul id="payments" class="cd-faq__group">
			<li class="cd-faq__title"><h2>Data access</h2></li>
		

	

			<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>How many students can I contact?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
            <p> There are limits to how many students you can contact at once to avoid malicious use of the platform however there are no limits to the total number of students that you can contact. We encourage you to reach out to as many students as possible!</p>
               </div>
				</div> <!-- cd-faq__content -->
			</li>
					<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>Why can't I see some students' CVs?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
            <p> Some students have not uploaded their CVs yet but we still think you should be able to see their profiles. We will integrate a filter function so that you can remove students with no CV from your results soon!</p>
             </div>
				</div> <!-- cd-faq__content -->
			</li>
			
					<li class="cd-faq__item">
				<a class="cd-faq__trigger" href="#0"><span>What is the difference between shortlist and contacts?</span></a>
				<div class="cd-faq__content">
          <div class="text-component">
            <p> Your contacts are all the students whose details you have accessed whereas the shortlist page is your own space that you can use to store candidates that you are particularly interested in.  </p>
               </div>
				</div> <!-- cd-faq__content -->
			</li>
			
		</ul> <!-- cd-faq__group -->


	</div> <!-- cd-faq__items -->

	<a href="#0" class="cd-faq__close-panel text-replace">Close</a>
  
  <div class="cd-faq__overlay" aria-hidden="true"></div>
</section>
<div class="banner_bottom" id="contact">
		<div class="container">
            <div class="mail_form">
	            <h3 class="tittle">Contact your account manager</h3>
        	    <div style="margin-top: 2em;">
	                <p>If you have any questions regarding using the platform, feel free to get in touch with your account manager <?php echo $am_details["name"]; ?>. We'll always reply within 24hrs.</p>
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
<script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="assets/js/main.js"></script> 
    <?php
        include_once "components/new_footer.php";
    ?>
</body>
</html>