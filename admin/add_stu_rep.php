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

if (isset($_POST['firstname'])) {
  $firstname = $_POST['firstname'];
  $surname = $_POST['surname'];
  $email = $_POST['email'];
  $uni = $_POST["university"];
  $c_s_name = $_POST['c_s_name'];
  $position = $_POST['position'];
  if ($position == "other") {
    $position = $_POST['other_pos'];
  }
  $descr = $_POST["descr"];

  /* Upload into rep table */
  $sql = "INSERT INTO `rep_network` (`firstname`, `lastname`, `email`, `college_society_name`, `position`, `descr`, `university`) "
       . "VALUES (:fname, :sname, :email, :c_s_name, :pos, :descr, :uni)";
       
  DB::query($sql, array(":fname" => $firstname, ":sname" => $surname, ":email" => $email, ":c_s_name" => $c_s_name, ":pos" => $position, ":descr" => $descr, ":uni" => $uni));

  $rid = DB::query("SELECT `id` FROM `rep_network` WHERE `email`=:email", array(":email" => $email))[0]["id"];

  $path = '../resources/och_team_photos/';
  if ($_FILES["photo"]["error"] > 0) {
    echo "File Error";
  } else {
    $ext = end(explode(".", $_FILES["photo"]["name"]));
    $f_name = "Advisor-" . $rid . "-photo." . $ext;
    $tmp_name = $_FILES['photo']['tmp_name'];
    $final_path = ltrim(rtrim($path.$f_name));
    move_uploaded_file($tmp_name, $final_path);
    $sql = "UPDATE `rep_network` SET `photo_url`=:p_url WHERE `id`=:id";
    DB::query($sql, array(":p_url" => $f_name, ":id" => $rid));
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
              <h3>Add a Student Rep</h3>
            </div>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            <label>First name</label>
            <input type="text" name="firstname" class="form-control" required>
            <br />
            <label>Surname</label>
            <input type="text" name="surname" class="form-control" required>
            <br/>
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            <br />
            <label>University</label>
            <select name="university" class="form-control" required>
                <option value="Cambridge">Cambridge</option>
                <option value="Durham">Durham</option>
                <option value="Imperial">Imperial</option>
                <option value="Oxford">Oxford</option>
            </select>
            <label>College/Society Name</label>
            <input type="text" name="c_s_name" class="form-control" required>
            <br />
            <label>Position</label>
            <select name="position" class="form-control">
              <option value="">Please choose an option</option>
              <option value="Student Academic Advisor">Student Academic Advisor</option>
              <option value="Student Society Advisor">Student Society Advisor</option>
              <option value="University Partner">University Partner</option>
              <option value="Co-Founder">Co-Founder</option>
              <option value="other">Other</option>
            </select>
            <br/>
            <label>If other please specify</label>
            <input type="text" name="other_pos" class="form-control">
            <br />
            <label>Description</label>
            <textarea name="descr" class="form-control"></textarea>
            <br />
            <label>Upload a photo</label>
            <input type="file" class="btn btn-primary" name="photo">
            <br/>
            <div class="text-right"><button class="btn btn-primary" type="submit">Submit</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('footer.php'); ?>