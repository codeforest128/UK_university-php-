<?php
include('../../classes/DB.php');
include('../../classes/login.php');


if (isset($_POST['changepassword'])) {
    $token = $_POST['token'];

    $client = DB::query('SELECT * FROM clients');

     $client_id = 0;

     foreach ($client as $key => $value) {
         if ($token==md5($value['id'])) {
             $client_id = $value['id'];
         }
     }

     if ($client_id==0) {
         $_SESSION['flash'] = 'Invalid Request';
         header("location:login.php");
     }


    $password = $_POST['newpassword'];

    $password = password_hash($password, PASSWORD_BCRYPT);

    DB::query('UPDATE clients SET password="'.$password.'" WHERE id="'.$client_id.'"');

    $_SESSION['flash'] = 'Password Updated successfully';
    header("location:login.php");

}


$token = $_GET['token'];

 $client = DB::query('SELECT * FROM clients');

 $client_id = 0;

 foreach ($client as $key => $value) {
     if ($token==md5($value['id'])) {
         $client_id = $value['id'];
     }
 }

 if ($client_id==0) {
     $_SESSION['flash'] = 'Invalid Link';
     header("location:login.php");
 }


?>

<!DOCTYPE html>
<html>
<?php
    $title = "Forgot Password";
    include_once "components/header.php";
?>
<body>
    <?php
           include_once "components/simple_navbar.php";
    ?>
    <div class="banner_bottom">
        <div class="container">
            <div class="tittle_head">
                <h3 class="tittle three">Please provide an email for password reset</h3>
            </div>
            <div class="inner_sec_info">
                <div class="col-md-4"></div>
                <div class="login-clean col-md-4">
        <form method="post" onsubmit="check_duel(event)">
            <input type="hidden" name="token" value="<?php echo $token;?>">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-navigate" style="color: rgb(48,23,119);"></i></div>
            <div class="form-group"><input class="form-control" required="" type="password" name="newpassword" placeholder="New password"></div>
            <div class="form-group"><input class="form-control" required type="password" name="newpasswordrepeat" placeholder="Repeat password"></div>
            <div class="form-group"><input class="btn btn-primary btn-block" type="submit" value="Reset password" name="changepassword" style="background-color: rgb(48,23,119);"></div><a href="login.php" class="forgot">Remembered your password? Login here.</a><a href="signup.html" class="forgot">Don't have an Account?</a></form>
    </div>
            </div>
            
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <?php
         include_once "components/new_footer.php";
    ?>



    <script type="text/javascript">
        
        function check_duel(eve) {

            if ($('[name=newpassword]').val().length<6){

                     eve.preventDefault();
                alert('Password should be atleast 6 charecters');
                return false;

            }

            if ($('[name=newpassword]').val()!=$('[name=newpasswordrepeat]').val()){
                     eve.preventDefault();
                alert('confirm password not match !');
                return false;
            }
            
        }
    </script>
</body>
</html>

