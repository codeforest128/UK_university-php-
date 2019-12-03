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

if (isset($_POST['title'])) {
  $title = $_POST['title'];
  $b_descr = $_POST['b_descr'];
  $body = $_POST['body'];
  $l_date = $_POST['live_date'];
  $author = $_POST['author'];
  $tags = $_POST["tags"];
  $processed_tags = "[";
  $split_tags = explode(",", $tags);
  foreach($split_tags as $tag) {
    $processed_tags .= "\"" . ltrim(rtrim($tag)) . "\", ";
  }
  $processed_tags = substr($processed_tags, 0, -2) . "]";

  /* Upload into rep table */
  $sql = "INSERT INTO `blogs` (`title`, `brief_descr`, `body`, `scheduled_date`, `author`, `tags`) "
       . "VALUES (:title, :bdescr, :body, :sdate, :author, :tags)";
       
  DB::query($sql, array(":title" => $title, ":bdescr" => $b_descr, ":body" => $body, ":sdate" => $l_date, ":author" => $author, ":tags" => $processed_tags));

  $bid = DB::query("SELECT `id` FROM `blogs` WHERE `title`=:title", array(":title" => $title))[0]["id"];

  $path = '../resources/blog_photos/';
  if ($_FILES["photo"]["error"] > 0) {
    echo "File Error";
  } else {
    $ext = end(explode(".", $_FILES["photo"]["name"]));
    $f_name = "Blog-" . $bid . "-photo." . $ext;
    $tmp_name = $_FILES['photo']['tmp_name'];
    $final_path = ltrim(rtrim($path.$f_name));
    move_uploaded_file($tmp_name, $final_path);
    $sql = "UPDATE `blogs` SET `img_url`=:p_url WHERE `id`=:id";
    DB::query($sql, array(":p_url" => $f_name, ":id" => $bid));
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
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
            <br />
            <label>Brief Description</label>
            <input type="text" name="b_descr" class="form-control" required>
            <br/>
            <label>Body</label>
            <textarea class="form-control" name="body" id="form_blog_body"></textarea>
            <br />
            <label>Scheduled Date</label>
            <input type="date" name="live_date" class="form-control" required>
            <br />
            <label>Author</label>
            <input type="text" name="author" class="form-control">
            <br />
            <label>Tags (Please enter as comma seperated list)</label>
            <input type="text" name="tags" class="form-control">
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