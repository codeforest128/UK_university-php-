<?php
    include_once "../classes/DB.php";
    include_once "../classes/login.php";


    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $itd = ($id / 4000);
        $exists = DB::query('SELECT verified FROM verification WHERE code=:code', array(':code' => $id))[0]['verified'];
        if ($exists == 0) {
            DB::query('UPDATE verification SET verified="1" WHERE code=:code', array(':code' => $id));
            DB::query('UPDATE posts SET verified="1" WHERE user_id=:code', array(':code' => $itd));
            // Check if reference code is in use and update table if so
            if (isset($_GET['ref'])) {
                // Get current list of students who've used link
                $ref = $_GET['ref'];
                $cList = DB::query('SELECT stu_ids_verified FROM reference_codes WHERE code=:code', array(':code' => $ref))[0]['stu_ids_verified'];
                if (isset($cList)) {
                    $nList = substr($cList, 0, -1);
                    $nList .= ", " . $itd . "]";
                } else {
                    $nList = "[" . $itd . "]";
                }
                DB::query('UPDATE reference_codes SET stu_ids_verified=:nList WHERE code=:code', array(':nList' => $nList, ':code' => $ref));
            }
        }
    }

    if (!Login::isLoggedIn()) {
        header("Location: login.php");
        exit;
    }

    // Obtian user Id
    if (isset($_COOKIE['SNID'])) {
        $token = $_COOKIE['SNID'];
        $userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token' => sha1($token)))[0]['user_id'];
        $shortlist = DB::query('SELECT * FROM short_list WHERE student_id=:userid', array(':userid'=>$userid));
        $noshortlist = count($shortlist);
        $contacts = DB::query('SELECT * FROM contacts WHERE student_id=:userid', array(':userid'=>$userid));
        $contacts_count = count($contacts);
    }
    
    // Data to populate page
    $sql = "SELECT `firstname`, `lastname`, `mob`, `ethnicity`, `nationality`, `gender`, `school`, `qualification`, `course`, `course_end`, `location`, `ind1`, `ind2`, `ind3`, `type`, `availability`, `user_id`, `posted_at`, `college` "
         . "FROM `posts` "
         . "WHERE `user_id`=:uid";
    $details = DB::query($sql, array(':uid' => $userid));
    
    $sql = "SELECT `email` FROM `users` WHERE `id`=:uid";
    $email = DB::query($sql, array(':uid' => $userid))[0]["email"];
    
    $sql = "SELECT `email` FROM `altemail` WHERE `student_id`=:uid";
    $altemail = DB::query($sql, array(':uid' => $userid))[0]["email"];
	
	
	 if (strpos($email, '.ox.ac.uk') !== false) {
        $courses = $ox_courses;
        $colleges = $ox_colleges;
        $university = "University of Oxford";
    } else if (strpos($email, '.cam.ac.uk') !== false) {
        $courses = $cam_courses;
        $colleges = $cam_colleges;
        $university = "University of Cambridge";
    } else if (strpos($email, 'durham.ac.uk') !== false) {
        $courses = $dur_courses;
        $colleges = $dur_colleges;
        $university = "University of Durham";
    } else if (strpos($email, 'imperial.ac.uk') !== false) {
        $courses = $imp_full_courses;
        $university = "Imperial College London";
        $colleges = array();
    } else if (strpos($email, "lse.ac.uk") !== false) {
        $courses = $lse_full_courses;
        $university = "London School of Economics";
        $colleges = array();
    } else if (strpos($email, 'ucl.ac.uk') !== false) {
        $courses = $ucl_full_courses;
        $university = "University College London";
        $college = array();
    }

	
	
?>

<!-- Account verification -->


<!DOCTYPE html>
<html>
<?php 
    include_once "components/header.php";
?>
  <style>
  
    .navbar {
      padding-top: 0.2rem !important;
      padding-bottom: 0.2rem !important;
    }

    .account-pages {
      background-color: #f8f9fa !important;
      padding: 25px 0px;
    }

    .personal-detaile-sec {
      background: #fff;
      padding: 20px;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.05);
    }

    .personal-detaile-sec h1 {
      font-weight: 400;
      padding-bottom: 25px;
      color: #595454;
      text-indent: 10px;
    }
    
    /*.box-state {
        height: 120px;
        width: 120px;
        border-radius: 100%;
        border: 1px solid #333;
        margin: auto;
    }*/
    
    
    .user-lists {
      padding: 20px 0px;
    }

    .user-lists h1 {
      font-size: 20px;
      color: #333;
    }

    .user-lists h4 {
      font-size: 14px;
      padding: 6px 0px;
    }

    .panel {
      border-width: 0 0 1px 0;
      border-style: solid;
      border-color: #fff;
      background: none;
      box-shadow: none;
    }

    .panel:last-child {
      border-bottom: none;
    }

    .panel-group>.panel:first-child .panel-heading {
      border-radius: 4px 4px 0 0;
    }

    .panel-group .panel {
      border-radius: 0;
    }

    .panel-group .panel+.panel {
      margin-top: 0;
    }

    .panel-heading {
      background-color: #fff;
      border-radius: 0;
      border: none;
      color: #0c0b0b !important;
      padding: 0;
      box-shadow: 1px 3px 5px rgba(134, 127, 127, 0.19);
    }
    
    h4.panel-title {
      margin-bottom: .5em;
    }

    .panel-title button {
      display: block;
      color: #595454;
      padding: 19px;
      position: relative;
      font-size: 17px;
      font-weight: 600;
      background: none;
      border: none;
      width: 100%;
      text-align: left;
    }
    
    .panel-title button:focus {
        outline: none;
    }
    
    .panel-title button i {
      float: right;
    }

    .panel-body {
      background: #fff;
      padding: 16px;
    }

    .panel:last-child .panel-body {
      border-radius: 0 0 4px 4px;
    }

    .panel:last-child .panel-heading {
      border-radius: 0 0 4px 4px;
      transition: border-radius 0.3s linear 0.2s;
    }

    .panel:last-child .panel-heading.active {
      border-radius: 0;
      transition: border-radius linear 0s;
    }
    
    
    
    /* #bs-collapse icon scale option */

    .panel-heading.active button:before {
      content: ' ';
      transition: all 0.5s;
      transform: scale(0);
    }

    #bs-collapse .panel-heading button:after {
      content: ' ';
      font-size: 24px;

      right: 5px;
      top: 10px;
      transform: scale(0);
      transition: all 0.5s;
    }

    #bs-collapse .panel-heading.active button:after {
      transform: scale(1);
      transition: all 0.5s;
    }
    
    /* #accordion rotate icon option */
    
    #accordion .panel .panel-heading .panel-title button i:before {
      right: 5px;
      top: 10px;
      transform: rotate(180deg);
      transition: all 0.5s;
    }

    #accordion .panel .panel-heading.active .panel-title button i:after {
      transform: rotate(0deg);
      transition: all 0.5s;
    }
    
    .animated-text .form-control {
      border: none !important;
      box-shadow: 0px 0px 1px #7d7e80;

    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .my-network .count {
      color: #f25006;
      font-size: 27px;
    }

    .my-network {
      background: #fff;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.23);
    }

    .my-network h2 {
      font-size: 18px;
      text-transform: uppercase;
      background: #4b4e4c;
      color: #fff;
      padding: 9px;
    }

    .my-network h3 {
      font-size: 16px;
      padding: 10px 0;
    }

    .my-network h1 {
      font-size: 22px;
    }

    .my-network p {
      padding: 1px 12px 24px;
    }

    .upload-box h3 {
      font-size: 20px;
    }
    
    .box-state img {
      height: 150px;
      border-radius: 100%;
      border: 1px solid #333;
    }
    
    .update-resume h2 {
      font-size: 18px;
      text-transform: uppercase;
      background: #00003c;
      color: #fff;
      padding: 9px;

    }

    .update-resume {
      background: #fff;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.05);
    }

    .resume-count {
      color: #60c211;
      font-size: 27px;
    }

    .upload-box {
      padding: 30px 0px;
    }

    .upload-img {
      background: #acd7fb;
    }
    
    .icon-right {
      float: right;
    }

    .loader-box h2 {
      font-size: 25px;
    }

    .student-icon img {
      height: 40px;
      width: 40px;
      float: left;
      border-radius: 100%;
    }

    .clean-navbar .navbar-nav .nav-link {
      font-weight: 600;
      font-size: .8rem;
      text-transform: uppercase;
      float: left;
    }

    .logout-icon {
      line-height: 2;
    }

    .student-icon {
      border-right: 2px solid #908c8c;
      line-height: 2;
    }

    .btn-dark1 {
      width: 160px;
      background: #f57553;
      color: #fff;
      margin: 15px 0px;
    }

    .btn-dark2 {
      width: 160px;
      border: 1px solid #333;
      color: #e94c23 !important;
      margin: 15px 15px;

    }

    .btn-info {
      color: #4b4e4c;
      background-color: #acd7fb4d;
      border-color: #3b99e0;
    }

    .footer-send-btn {
      border-top: 1px solid #3333
    }

    .btn-dark1:hover {
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    .btn-dark2:hover {
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
      background: ;
    }

    .btn-info2 {
      color: #fff;
      background-color: #f57553;
    }

    .state-btn {
      margin-top: 30%;
    }

    .form-wrapper {
      margin: 10px auto;
    }

    .form-group {
      position: relative;

      &+.form-group {
        margin-top: 30px;
      }
    }

    .form-label {
      position: absolute;
      left: 0;
      top: 10px;
      background-color: #fff;
      z-index: 10;
      color: #201e1e;
      font-size: 14px;
      transition: transform 150ms ease-out, font-size 150ms ease-out;
    }

    .focused .form-label {
      transform: translateY(-125%);
      font-size: .75em;
    }

    .form-input {
      position: relative;
      padding: 12px 0px 5px 0;
      width: 100%;
      outline: 0;
      border: 0;
      box-shadow: 0 1px 0 0 #e5e5e5;
      transition: box-shadow 150ms ease-out;

      &:focus {
        box-shadow: 0 2px 0 0 blue;
      }
    }

    .form-input.filled {
      box-shadow: 0 2px 0 0 lightgreen;
    }

    .star {
      color: #ed5f3a;
    }

    .account-form {
      padding-right: 0px;
      padding-left: 0px;
      border: 1px solid #5f5c5c1a;
    }

    .education-title {
      border-bottom: 2px solid #acd7b2;
      font-size: 22px;
      padding: 8px 0px;
      color: #00003b;
    }

    .ks-cboxtags li {
      float: left;

    }

    .ks-cboxtags li label {
      display: inline-block;
      background-color: rgba(255, 255, 255, .9);
      border: 2px solid rgba(139, 139, 139, .3);
      color: #adadad;
      border-radius: 25px;
      white-space: nowrap;
      margin: 3px 0px;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      -webkit-tap-highlight-color: transparent;
      transition: all .2s;
    }

    .ks-cboxtags li label {
      padding: 3px 9px;
      cursor: pointer;
      margin: 3px;
      font-size: 15px;
    }

    .ks-cboxtags li label::before {
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      -webkit-font-smoothing: antialiased;
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      font-size: 12px;
      padding: 2px 6px 2px 2px;
      content: "\f067";
      transition: transform .3s ease-in-out;
    }

    .ks-cboxtags li input[type="checkbox"] {
      position: absolute;
      opacity: 0;
    }

    .ks-cboxtags li input[type="checkbox"]:checked+label {
      border: 2px solid #1bdbf8;
      background-color: #12bbd4;
      color: #fff;
      transition: all .2s;
    }

    .ks-cboxtags li input[type="checkbox"]:checked+label::before {
      content: "\f00c";
      transform: rotate(-360deg);
      transition: transform .3s ease-in-out;
    }

    .read-form h2 {
      font-size: 18px;
      color: #208ec5;
      font-weight: bold;
    }

    .table-responsive {
      display: inline-block;
      width: 100%;
      overflow-x: auto;
    }

    .info h4 {
      font-size: 18px;
      margin-bottom: 16px;
    }

    a:hover {
      text-decoration: none;
    }
    
    .modal-header .close {
      position: absolute;
      top: 5px;
      right: 10px;
    }
    
    .cv_box {
        width: 100%;
    }
  </style>

  <?php //$pic = DB::query('SELECT * FROM pic WHERE userid=:userid', array(':userid' => $userid))[0]['pic']; ?>

<!-- </head> -->

<body>
    <?php 
        include_once "components/simple_navbar.php"; 
        include_once "components/sub_header.php";
    ?>
    <hr style="margin: 0px;"/>
    
<!-- Account page -->
<section class="account-pages bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="personal-detaile-sec text-center">
          <h3 style="margin-bottom: 20px;">User Profile</h3>
          <?php $pic = DB::query('SELECT * FROM pic WHERE userid=:userid', array(':userid' => $userid))[0]['pic']; ?>
          <div class="box-state">
            <img src="<?php if ($pic != '') {
                        echo $pic;
                      } else { ?> assets/img/avatars/avatar1.jpg <?php } ?>" alt="images" class="img-responsive" style="display: inline-block;">
            <!-- for pp data-toggle="modal" data-target="#upload_pic" -->
          </div>
          <!--   <a href="" data-toggle="modal" class="uplpic" data-target="#upload_pic" style="font-size:14px;">Change profile picture</a>-->
          <div class="user-lists">
            <h1><?php echo ($details[0]["firstname"] . ' ' . $details[0]["lastname"]); ?></h1>
            <p style="word-wrap: break-word;"><?= $email; ?></p>
            <br />
            <!-- <h4>Please verify your email address</h4>-->
            <div class="state-btn1" style="margin-top: 15px;">
              <a href="add-doc1.php" class="btn btn-primary"><i class="fas fa-fire-alt"></i> Update Account</a>
              <br />
              <br />
              <button class="btn btn-secondary " data-toggle="modal" data-target="#update_password"><i class="fas fa-key"></i> Change password</button>
              <!--  <button type="button" class="btn btn-info2 btn-block">View Profile</button>-->
            </div>
          </div>

        </div>

        <?php

        $resume = DB::query('SELECT * FROM images WHERE userid=:userid', array(':userid' => $userid));
        $verified = DB::query('SELECT * FROM verification WHERE userid=:userid', array(':userid' => $userid))[0]['verified'];
        $exists = DB::query('SELECT verified FROM verification WHERE userid=:userid', array(':userid' => $userid))[0]['verified'];

        $chkr_win = 9;
        $typer = '';

        $perc = 0;
        $circle = '';
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $test = 0;
        if ($resume != null) {
          $a = 1;
        } else {
          $a = 0;
        }

        if ($verified == 1) {
          $b = 1;
        } else {
          $b = 0;
        }
        if ($exists != '') {
          $c = 1;
        } else {
          $c = 0;
        }




        if ($pic != '') {
          $chkr_win = 1;
        } else {
          $chkr_win = 0;
          $typer = 'pic';
        }

        if ($resume) {
          $chkr_win = 1;
        } else {
          $chkr_win = 0;
          $typer = 'resume';
        }

        if ($verified == 1) {
          $chkr_win = 1;
        } else {
          $chkr_win = 0;
          $typer = 'verified';
        }
        $test = $a + $b + $c;

        if ($test == 0) {
          $perc = "0%";
          $circle = "";
        } else if ($test == 1) {
          $perc = "25%";
          $circle = "border-top: 16px solid #ea3b0c;";
        } else if ($test == 2) {
          $perc = "75%";
          $circle = "border-top: 16px solid #ea3b0c; border-right: 16px solid #ea3b0c;border-bottom: 16px solid #ea3b0c;";
        } else if ($test = 3) {

          $perc = "100%";
          $circle = "border-top: 16px solid #4CBB17; border-right: 16px solid #4CBB17;border-bottom: 16px solid #4CBB17;border-left: 16px solid #4CBB17; ";
        }





        ?>

        <div class="personal-detaile-sec">
          <div class="loader-box">
            <h2><?= $perc ?></h2>
          </div>

          <div class="user-lists text-center">
            <?php

            if ($chkr_win == 0 && $typer == 'verified') {
              $exists = DB::query('SELECT verified FROM verification WHERE userid=:userid', array(':userid' => $userid))[0]['verified'];
              if ($exists == 0) {
                echo ('<h2>Unverified</h2><h5>Please verify your email address by clicking the link that was sent to you <strong>If you cannot see it then please check your junk folders</strong></h5>');
                $perc = "20%";
              } else if ($firstname == "") {
                echo ('<h2>Incomplete</h2><h5>Please update you incomplete details</h5>');
                $perc = "20%";
              } else {
                echo ('<h2>Active</h2><h5>Your details are on the database</h5>');
                $perc = "100%";
              }
            } else {

              if ($typer == 'resume') {

                echo ('<h3>Please upload your CV</h3>');
                $perc = "40%";
              }




              if ($chkr_win == 1 && $typer == '' && $firstname != '') {

                echo ('<h3>Your account is complete and live, thank you</h3>');
                $perc = "100%";
              }

              if ($chkr_win == 1 && $typer == '' && $firstname == '') {
                echo ('<h3>Your account details are incomplete</h3>');
              }
            }





            ?>
            <style>
              .loader-box {
                border: 16px solid #f3f3f3;
                /* Light grey */
                <?= $circle ?>border-radius: 50%;
                width: 120px;
                height: 120px;
                margin: auto;
                align-items: center;
                display: flex;
                justify-content: center;
              }
            </style>
            <div class="state-btn" style="margin: 0;">
              <a href="delete-account.php" class="btn btn-primary" type="button" style="margin-top: 15px; color:black;"><i class="icon-notebook"></i>Remove account</a>
            </div>
          </div>
        </div>

        <?php
        $null = DB::query('SELECT firstname FROM posts WHERE user_id=:userid', array(':userid' => $userid))[0]['firstname'];
        $email = DB::query('SELECT email FROM users WHERE id=:userid', array(':userid' => $userid))[0]['email'];
		
		$cv_date = DB::query('SELECT uploaded_on FROM images WHERE userid=:userid', array(':userid' => $userid))[0]['uploaded_on'];
		$date=date_create($cv_date);
		$cv_display_date = date_format($date,"m/d/Y H:ia ");
		
		$cv_updated_date = DB::query('SELECT updated_on FROM images WHERE userid=:userid', array(':userid' => $userid))[0]['updated_on'];
		
		if($cv_updated_date!='' && $cv_updated_date!='0000-00-00 00:00:00' ){
		$date=date_create($cv_updated_date);	
		$cv_display_updated_date = date_format($date,"m/d/Y H:ia ");
		}else{
			$cv_display_updated_date = '';
		}
		
      
		
		
        ?>

      </div>
      <div class="col-md-6 account-form">
        <div class="personal-detaile-sec">
          <h3>Account Details</h3>
          <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <button data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Personal Details <i class="fa fa-angle-down icon-right"></i>
                  </button>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="panel-body">
                  <div class="form-wrapper">
                    <?php if ($null == null) {  ?>
                      <div class="col">
                        <div class="info">
                          <h3 style="margin: 8px 0px 8px;">Personal Details</h3>
                          <div class="row">
                            <div class="col-6">Name:</div>
                            <div class="col-6"><a href="update-account.php" class="badge badge-info "><i class="fas fa-plus"></i></i> Add detail</a><br /><br /></div>
                          </div>
                          <div class="row">
                            <div class="col-6">Ethnicity:</div>
                            <div class="col-6"><a href="update-account.php" class="badge badge-info "><i class="fas fa-plus"></i></i> Add detail</a><br /><br /></div>
                          </div>
                          <div class="row">
                            <div class="col-6">Nationality:</div>
                            <div class="col-6"><a href="update-account.php" class="badge badge-info "><i class="fas fa-plus"></i></i> Add detail</a><br /><br /></div>
                          </div>
                          <div class="row">
                            <div class="col-6">Phone:</div>
                            <div class="col-6"><a href="update-account.php" class="badge badge-info "><i class="fas fa-plus"></i></i> Add detail</a><br /><br /></div>
                          </div>
                          <div class="row">
                            <div class="col-6">Email:</div>
                            <div class="col-6"><a href="update-account.php" class="badge badge-info "><i class="fas fa-plus"></i></i> Add detail</a><br /><br /></div>
                          </div>
                          <div class="row">
                            <div class="col-6">Alternative email:</div>
                            <div class="col-6"><a href="update-account.php" class="badge badge-info"><i class="fas fa-plus"></i></i> Add detail</a><br /><br /></div>
                          </div>
                          <div class="row">
                            <div class="col-6">CV:</div>
                            <div class="col-6">
                              <?php if ($file_name != '') { ?> <a target="_blank" href="show_cv.php" class="btn btn-primary">View</a> <?php } else { ?>
                                <button class="btn upload-img" style="width: 200px;margin-right: 15px; " data-toggle="modal" data-target="#upload_cv"><i class="fas fa-cloud-upload-alt"></i> Upload CV</button>
                              <?php } ?>
                            </div>
                          </div>





                          <!-- Button to Open the Modal -->

                        </div>
                      </div>
                    </div>
                  </div>
                <?php } else {
                  foreach ($details as $detail) {
                    $ind1 = json_decode($detail['ind1'], true);
                    $ind2 = json_decode($detail['ind2'], true);

                    foreach ($ind1 as $inds1) {

                      $sectors .= '<label style="background-color:#acd7fb;color:#00003c;border-radius:25px;padding:10px 7px;margin-right:5px">' . $inds1 . '</label>';
                    }
                    foreach ($ind2 as $inds2) {

                      $kind .= '<label style="background-color:#acd7fb	;color:#00003c;border-radius:25px;padding:10px 7px;margin-right:5px">' . $inds2 . '</label>';
                    }
                    ?> 
                    <div class="col">
                      <div class="info">
                        <div class="table-responsive">
                          <table class="table m-0">
                            <tbody>
                              <tr>
                                <th scope="row">Full Name</th>
                                <td><?= $detail['firstname'] . ' ' . $detail['lastname']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Ethnicity</th>
                                <td><?= $detail['ethnicity']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Nationality</th>
                                <td><?= $detail['nationality']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Phone</th>
                                <td><?= $detail['mob']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Email</th>
                                <td><?= $email; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Alternative email</th>
                                <td><?= $altemail; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Current CV</th>
                                <td>
                                  <!--  <embed class="cv_box" src="client/components/cv_viewer.php?user=<?php //echo $userid; ?>"/>  -->
								  <?php if ($cv_display_updated_date != ''):?>
								  <td>Last updated on: <?= $cv_display_updated_date; ?></td>
								  <?php else: ?>
								  <td>Uploaded on: <?= $cv_display_date; ?></td>
								  <?php endif; ?>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of panel -->

              <div class="panel">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <button class="collapsed" data-target="#collapseTwo" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="collapseTwo">
                      Education <i class="fa fa-angle-down icon-right"></i>
                    </button>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="panel-body">
                    <?php if ($null == null) {  ?>
                      <p style="margin-left: 40px;">Course ends:<a href="update-account.php"> Complete profile</a></p>
                      <p style="margin-left: 40px;">Location:<a href="update-account.php"> Complete profile</a></p>
                      <p style="margin-left: 40px;">Available from: <a href="update-account.php"> Complete profile</a></p>
                    <?php } else {
                      foreach ($details as $detail) { ?>
                        <div class="table-responsive">
                          <table class="table m-0">

                            <tbody>
                              <tr>
                                <th scope="row">School</th>
                                <td><?= $detail['school']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">College</th>
                                <td><?= $detail['college']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Course</th>
                                <td><?= $detail['course']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Degree type</th>
                                <td><?= $detail['qualification']; ?></td>
                              </tr>
							  <th scope="row">University</th>
                                <td><?= $university; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>


                      </div>
                    </div>
                  </div>
                  <!-- end of panel -->

                  <div class="panel">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <button class="collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Work details <i class="fa fa-angle-down icon-right"></i>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                      <div class="panel-body">

                        <?php if ($null == null) {  ?>
                          <p style="margin-left: 40px;">Course ends:<a href="update-account.php"> Complete profile</a></p>
                          <p style="margin-left: 40px;">Location:<a href="update-account.php"> Complete profile</a></p>
                          <p style="margin-left: 40px;">Available from: <a href="update-account.php"> Complete profile</a></p>
                        <?php } else {
                          foreach ($details as $detail) { ?>
                            <div class="table-responsive">
                              <table class="table m-0">

                                <tbody>
                                  <tr>
                                    <th scope="row">Course ends</th>
                                    <td><?= $detail['course_end']; ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Location </th>
                                    <td><?= $detail['location']; ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Available from</th>
                                    <td><?= $detail['availability']; ?></td>
                                  </tr>
                              </table>
                            </div>
                            <hr style="margin-top: 0;">
                            <?php echo ('<h3 style="margin-bottom: 15px;">What kind of work would you like to do on a daily basis?</h3>' . $sectors . '        ');
                          }
                        } ?>
                        <hr>
                        <?php echo ('
                                    <h3 style="margin-bottom: 15px;">Which Sectors are you interested in?</h3>
										' . $kind . ' 
                            </div>
                        </div>');
                      }
                    } ?>

                  <?php  }
                } ?>
              </div>
            </div>
            <!-- end of panel -->
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="update-resume text-center">
          <h2>Update CV</h2>
          <div class="upload-box">
            <h3><span class="resume-count"><?= $contacts_count ?></span> views</h3>
            <p>on your profile in the last month</p>
            <p style="font-size:13px;margin-top:-20px;">Your details are currently live to employers</p>
            <div class="upload-btn-wrapper">
              <button class="btn upload-img" data-toggle="modal" data-target="#upload_cv"><i class="fas fa-cloud-upload-alt"></i> Update CV</button>
              <br />
              <!--      <button class="btn upload-img"
                          <input type="file" name="myfile" /><i class="fas fa-cloud-upload-alt"></i> Upload Resume
                          </button>-->
            </div>
          </div>
        </div>
        <div class="my-network text-center">
          <h2>My network</h2>
          <h3>Details accesses</h3>
          <h1><span class="count"><?= $noshortlist ?></span> companies</h1>
          <p>have accessed your contact details in the last month</p>
          <p style="font-size:13px;margin-top:-40px;"></p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include_once "components/footer.php"; ?>
</body>

<!--section class="footer-send-btn">
    <div class="container-fluid">
        <div class="submit-details d-flex justify-content-end">
            <button type="button" class="btn btn-dark1" id="submit" method="post" action="#">Submit</button>
            <button type="button" class="btn btn-dark2">Reset</button>
        </div>
    </div>
</section-->

<!-- The Modal -->
<div class="modal" id="altemail_reminder">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Keep in touch!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <p>We've noticed that you're graduating soon, if you'd like to keep using the platform please supply an alternative email!</p>
        <form action="register-alt-email.php" method="POST">
          <label>Alternative email</label>
          <div class="row">
            <div class="col-md-8">
              <input type="hidden" name="id" value="<?php echo $userid; ?>">
              <input type="text" name="altemail" class="form-control" required>
            </div>
            <div class="col-md-4"><button class="btn btn-primary btn-block">Update</button></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="upload_cv">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload CV</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="process_update_cv.php" method="post" enctype="multipart/form-data">


          <div class="row">
            <div class="col-md-12">
              <label>Select File to uploads</label>
              <input type="file" name="userfile" class="btn btn-primary btn-block" required>
              <br /><br />
            </div>
            <div class="col-md-6"><button class="btn btn-success btn-block">Upload</button></div>
        </form>
        <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button></div>
      </div>



    </div>

    <!-- Modal footer -->


  </div>
</div>
</div>





<!-- The Modal -->
<div class="modal" id="upload_pic">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Profile Picture</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="process_update_pic.php" method="post" enctype="multipart/form-data">


          <div class="row">
            <div class="col-md-12">
              <label>Select File to upload</label>
              <input type="file" name="userfile" class="btn btn-primary btn-block" required>
              <br /><br />
            </div>
            <div class="col-md-6"><button class="btn btn-success btn-block">Upload</button></div>
        </form>
        <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button></div>
      </div>



    </div>

    <!-- Modal footer -->


  </div>
</div>
</div>










<!-- The Modal -->
<div class="modal" id="update_password">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="process_update_password.php" onsubmit="check_password(event)" method="post" enctype="multipart/form-data">


          <div class="row">
            <div class="col-md-12">
              <label>Old password</label>
              <input type="password" name="password" class="form-control" required>
              <br />
              <label>New password</label>
              <input type="password" id="password" name="new_password" class="form-control" required>
              <span id="password_error" class="text-danger"></span>
              <br /><br />
            </div>
            <div class="col-md-6"><button class="btn btn-success btn-block">Update</button></div>
        </form>
        <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button></div>
      </div>



    </div>

    <!-- Modal footer -->


  </div>
</div>
</div>

<?php include 'flash.php'; ?>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
<script src="assets/js/smoothproducts.min.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/js/Bootstrap-Tags-Input-1.js"></script>
<script src="assets/js/Bootstrap-Tags-Input.js"></script>
<script>
  $(document).ready(function() {
    $('input').focus(function() {
      $(this).parents('.form-group').addClass('focused');
    });

    $('input').blur(function() {
      var inputValue = $(this).val();
      if (inputValue == "") {
        $(this).removeClass('filled');
        $(this).parents('.form-group').removeClass('focused');
      } else {
        $(this).addClass('filled');
      }
    })
    // Form read only
    document.getElementByClass('form-input').readOnly = true;

  });
</script>

<script>
  function check_password(e) {

    if ($('#password').val().length < 6) {

      $('#password_error').text('Password has to be atleast 6 characters');
      e.preventDefault();
      return false;
    } else {
      return true;
    }

  }
</script>

<!-- Script to check if graduating soon -->
<?php
  if ($detail["course_end"] == date("Y") && sizeof($altemail) == 0) {
?>
<script>
  $('#altemail_reminder').modal('show');
</script>
<?php
  }
?>
</body>

</html>