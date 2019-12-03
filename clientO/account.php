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

    # ***** NOT CERTAIN WHAT THIS IS FOR YET *****
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
    include_once "components/header.php";
?>

<!-- Add main account page contents -->
<section class="account-pages bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php include_once "components/sidebars/left.php"; ?>
                <br/><br/>
            </div>
            <div class="col-md-6">
                <?php include_once "components/account_details.php"; ?>
            </div>
            <div class="col-md-3">
                <?php include_once "components/sidebars/right.php"; ?>
            </div>
        </div>
    </div>
</section>
<style>
    html{
            background-color: #EEF8FC!important;
        
    }
    
</style>

<?php
    include_once "components/footer.php";
?>

<!-- Load in JQuery -->
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="signature_js/jquery.ui.touch-punch.min.js"></script>

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
        include_once "components/modal.php";
    }
?>