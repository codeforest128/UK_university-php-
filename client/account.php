<?php
    # Drag in classes
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
    
    # Check if logged in      
    if (!Login::isClientLoggedIn()) {
        header("Location: login.php");
    }

    # Verify cookies
    if (isset($_COOKIE['SNID'])) {			
		$token = $_COOKIE['SNID'];
        $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
		$sectors = "";
		$kind = "";
    }
    
    # Check if logout has been requested 
    if (array_key_exists('logout', $_POST)) {
        $sql = "DELETE FROM client_login_token "
             . "WHERE client_id = :clientid";
	    DB::query($sql, array(':clientid'=>Login::isClientLoggedIn()));
	    header("Location: login.php");
    }

    # Check if a signature has just been registered for first time login 
    if (isset($_POST['signature'])) {
        # Grab signature image
        $img = $_POST['signature'];

        # Write signature to file
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $image_name =  'signatures/sign_' . time() . '.png';
        file_put_contents($image_name, $data);

        # Get company details
        $company_name = $_POST['company_name'];
        $signer_name = $_POST['signer_name'];
        $sign_date = date('Y-m-d');

        $token = $_COOKIE['SNID'];
        $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];

        # Commit signature path to database
        $sql = "UPDATE clients SET privacy='1',signature='" . $image_name . "',signer_name='" . $signer_name . "',sign_date='" . $sign_date . "' WHERE id=" . $clientid;
        $update = DB::query($sql);

        # Select all client details?
        $sql = "SELECT * FROM  client_details WHERE client_id=" . $clientid;
        $client_details = DB::query($sql);
        $client_detail_id = $client_details[0]['id'];

        # Update the client information with the company name
        $sql = "UPDATE client_details SET company_name='" . $company_name . "' WHERE id=" . $client_detail_id;
        $update = DB::query($sql);

        # Refresh page
        header("Location: account.php");
    }
    
    if (isset($_POST['contact_name'])) {
        $contact_name = $_POST['contact_name'];
        $contact_email = $_POST['contact_email'];
        $contact_tel = $_POST['contact_tel'];
        $company_name = $_POST['company_name'];
        $all_email = $_POST['all_email'];

        $token = $_COOKIE['SNID'];
        $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];

        # Updates the client details... not so certain why?
        $sql = "UPDATE client_details SET contact_name='" . $contact_name . "',contact_email='" . $contact_email . "',contact_tel='" . $contact_tel . "',company_name='" . $company_name . "',all_email='" . $all_email . "' WHERE client_id=" . $clientid;
        $update = DB::query($sql);
        header("Location: account.php");
    }
?>

<?php
    # Begin forming document
    $page_title = "Account";
    include_once "components/header.php";
?>

<style>

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
<body>
    <?php
        include_once "components/new_navbar.php";
    ?>

<!-- Add main account page contents -->
<section class="account-pages bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php include_once "components/sidebars/left.php"; ?>
                <br/><br/>
            </div>
            <div class="col-md-6 account-form">
                <?php include_once "components/account_details.php"; ?>
            </div>
            <div class="col-md-3">
                <?php include_once "components/sidebars/right.php"; ?>
            </div>
        </div>
    </div>
</section>
<!--<style>
    html{
        background-color: #EEF8FC!important;
    }
    
</style>-->

<?php
    include_once "components/new_footer.php";
?>
</body>
<?php
    include_once "components/modals/change_password.php";
?>
</html>


<!-- Load in JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Load in Signature support -->
<link type="text/css" href="css/jquery.signature.css" rel="stylesheet">
<script type="text/javascript" src="signature_js/jquery.signature.js"></script>

<!-- Check if it's first time login / if they've signed agreement -->
<?php
    $token = $_COOKIE['SNID'];
    $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
    $sql = "SELECT `privacy` FROM `clients` WHERE `id`=:cid";
    $client_priv = DB::query($sql, array(":cid" => $client_id))[0]["privacy"];
    if ($client_priv == 0) {
        include_once "components/modals/privacy_modal.php";
    }
?>