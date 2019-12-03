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

if (isset($_POST['name'])) {
  $name = $_POST['name'];
  $uni = $_POST['university'];
  $focus = $_POST['focus'];
  $email = $_POST["email"];
  $web_link = $_POST['web_link'];
  $fb_link = $_POST['fb_link'];
  $sp_link = $_POST['sp_link'];
  $descr = $_POST["descr"];

  /* Upload into rep table */
  $sql = "INSERT INTO `soc_network` (`name`, `university`, `focus`, `email`, `website_link`, `facebook_link`, `signup_link`, `description`) "
       . "VALUES (:name, :uni, :focus, :email, :web_link, :fb_link, :sp_link, :descr)";
  DB::query($sql, array(":name" => $name, ":uni" => $uni, ":focus" => $focus, ":email" => $email, ":web_link" => $web_link, ":fb_link" => $fb_link, ":sp_link" => $sp_link, ":descr" => $descr));

  $sid = DB::query("SELECT `id` FROM `soc_network` WHERE `email`=:email", array(":email" => $email))[0]["id"];

  $path = '../resources/och_team_photos/';
  if ($_FILES["photo"]["error"] > 0) {
    echo "File Error";
  } else {
    $ext = end(explode(".", $_FILES["photo"]["name"]));
    $f_name = "Society-" . $sid . "-photo." . $ext;
    $tmp_name = $_FILES['photo']['tmp_name'];
    $final_path = ltrim(rtrim($path.$f_name));
    move_uploaded_file($tmp_name, $final_path);
    $sql = "UPDATE `soc_network` SET `image_root`=:p_url WHERE `id`=:id";
    DB::query($sql, array(":p_url" => $f_name, ":id" => $sid));
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
              <h3>Add a Society</h3>
            </div>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
            <br />
            <label>University</label>
            <select name="university" class="form-control" required>
                <option value="Cambridge">Cambridge</option>
                <option value="Durham">Durham</option>
                <option value="Imperial">Imperial</option>
                <option value="Oxford">Oxford</option>
            </select>
            <br/>
            <label>Society Focus</label>
            <input type="text" name="focus" class="form-control" required>
            <br/>
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            <br />
            <label>Website Link</label>
            <input type="text" name="web_link" class="form-control" required>
            <br />
            <label>Facebook Link</label>
            <input type="text" name="fb_link" class="form-control">
            <br />
            <label>Signup Link</label>
            <input type="text" name="sp_link" class="form-control">
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