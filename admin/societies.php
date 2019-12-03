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
              <h3>Societies</h3>
            </div>
            <div class="col text-right"><a href="add_soc.php"><button class="btn btn-primary">Add Society</button></a></div>
          </div>
          <?php
            $all_team = DB::query('SELECT * FROM soc_network ORDER by id desc');
          ?>
          <table id="table_id" class="display">
            <thead>
              <tr>
                <th>Name</th>
                <th>University</th>
                <th>Focus</th>
                <th>Email</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($all_team as $keyTeam => $valueTeam) {
              ?>
              <tr>
                <td><?php echo $valueTeam["name"]; ?></td>
                <td><?php echo $valueTeam["university"]; ?></td>
                <td><?php echo $valueTeam["focus"]; ?></td>
                <td><?php echo $valueTeam["email"]; ?></td>
                <td><?php echo $valueTeam["description"]; ?></td>
              </tr>
              <?php 
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('footer.php'); ?>