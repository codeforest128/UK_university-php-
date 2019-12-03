<?php
include('../../classes/DB.php');
include('../../classes/login.php');

if (!Login::isAdminLoggedIn()) {
  header("Location: login.php");
}
if (isset($_COOKIE['SNID'])) {
  $token = $_COOKIE['SNID'];
  $admin_id = DB::query('SELECT admin_id FROM admin_login_tokens WHERE token=:token', array(':token' => sha1($token)))[0]['admin_id'];
}
if (array_key_exists('logout', $_POST)) {
  DB::query('DELETE FROM admin_login_tokens WHERE admin_id=:admin_id', array(':admin_id' => Login::isAdminLoggedIn()));
  header("Location: login.php");
}

$sql = "SELECT id, name FROM `client_account_managers`";
$am_details = DB::query($sql, null);

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $company_name = $_POST['company_name'];
  $all_email = $_POST['all_email'];
  $contact_name = $_POST['contact_name'];
  $contact_email = $_POST['contact_email'];
  $contact_tel = $_POST['contact_tel'];
  $note = $_POST['note'];
  $is_demo = $_POST['is_demo'];
  $student_limit = $_POST['student_limit'];
  $created_at = date('Y-m-d');
  $chk_email = DB::query('SELECT * FROM clients WHERE email="' . $email . '"');
  $amid = $_POST["account_manager"];
  $xl_lmt = $_POST["excel_limit"];
  $be_lmt = $_POST["bulk_email"];

  if (!isset($chk_email[0]['id'])) {

    $sql = "INSERT INTO clients (username, email, password,is_demo,student_limit) VALUES ('" . $username . "', '" . $email . "', '" . $password . "', '" . $is_demo . "', '" . $student_limit . "')";
    $add_client = DB::query($sql);

    $client_id = DB::query('SELECT * FROM clients WHERE email="' . $email . '"')[0]['id'];

    $client_limits = "{\"xl\":\"" . $xl_lmt . "\", \"be\":\"" . $be_lmt . "\"}";
    
    $student_notes = "{}";
    
    $sql = "INSERT INTO `client_details` "
         . "(client_id, company_name, all_email, contact_name, contact_email, contact_tel, note, created_at, client_limits, account_manager_id) "
         . "VALUES "
         . "(:cid, :compname, :allemail, :contname, :contemail, :conttel, :note, :created, :limits, :amid)";
    DB::query($sql, array(":cid" => $client_id, ":compname" => $company_name, ":allemail" => $all_email, ":contname" => $contact_name, ":contemail" => $contact_email, ":conttel" => $contact_tel, ":note" => $note, ":created" => $created_at, ":limits" => $client_limits, ":amid" => $amid));
    
    $sql = "INSERT INTO `client_limit_counters` " 
         . "(excel_downloads, bulk_email, client_id) "
         . "VALUES (:xcel, :be, :cid)";
    DB::query($sql, array(":xcel" => $xl_lmt, ":be" => $be_lmt, ":cid" => $client_id));

    header("Location: clients.php");
  }
}
?>
<?php include('header.php'); ?>

<section class="account-pages bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <?php include 'left_sidebar.php'; ?>
      </div>
      <div class="col-md-9 account-form">
        <div class="personal-detaile-sec ">
          <div class="row">
            <div class="col">
              <h3>Add A Client</h3>
            </div>
          </div>
          <form action="" method="post">
            <label>Client Username</label>
            <input type="text" name="username" class="form-control" required>
            <br />
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            <br />
            <label>Password</label>
            <input type="text" name="password" class="form-control" required>
            <br />
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control">
            <br />
            <label>All Email</label>
            <input type="text" name="all_email" class="form-control">
            <br />
            <label>Contact Name</label>
            <input type="text" name="contact_name" class="form-control">
            <br />
            <label>Contact Email</label>
            <input type="text" name="contact_email" class="form-control">
            <br />
            <label>Telephone</label>
            <input type="text" name="contact_tel" class="form-control">
            <br />
            <label>Note</label>
            <input type="text" name="note" class="form-control">
            <br />
            <label>Is Demo Account</label>
            <select name="is_demo" class="form-control">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            <br/>
            <label>Student View limit</label>
            <input type="number" name="student_limit" class="form-control" value="25">
            <br />
            <label>Excel downloads limit</label>
            <select name="excel_limit" class="form-control">
                <option value="50">50</option>
                <option value="150">150</option>
            </select>
            <br/>
            <label>Bulk email limits</label>
            <select name="bulk_email" class="form-control">
                <option value="25">25</option>
                <option value="75">75</option>
            </select>
            <br/>
            <label>Account Manager</label>
            <select name="account_manager" class="form-control">
                <?php
                    foreach ($am_details as $am) {
                        echo "<option value='" . $am["id"] . "'>" . $am["name"] . "</option>";
                    }
                ?>
            </select>
            <div class="text-right"><button class="btn btn-primary" style="margin-top: 1em;" type="submit">Submit</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('footer.php'); ?>