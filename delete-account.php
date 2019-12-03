<?php
    include_once "../classes/DB.php";
    include_once "../classes/login.php";
    
    if (!Login::isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
    
    if (isset($_COOKIE['SNID'])) {
        $token = $_COOKIE['SNID'];
        $userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token' => sha1($token)))[0]['user_id'];
    }
    
    $delete = $_GET['account'];
    if ($delete == "delete") {
        DB::query('DELETE FROM posts WHERE user_id = :userid', array(':userid' => $userid));
        DB::query('DELETE FROM images WHERE userid = :userid', array(':userid' => $userid));
        DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid' => Login::isLoggedIn()));
        DB::query('DELETE FROM users WHERE id = :userid', array(':userid' => $userid));
        DB::query("DELETE FROM `altemail` WHERE student_id = :userid", array(":userid" => $userid));
        header("Location: signup.php");
    }
    
    if (array_key_exists('logout', $_POST)) {
        DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid' => Login::isLoggedIn()));
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<?php
    $title = "Delete Account";
    include_once "components/header.php";
?>
<style>
    body, html {
        height: 100%;
    }
</style>
<body>
    <?php
        include_once "components/simple_navbar.php"
    ?>
    <main class="page product-page" style="height: 50%;">
        <section class="clean-block clean-product dark">
            <div class="container" style="text-align: center;">
                <div class="block-heading">
                </div>
                <div class="block-content" style="width: 60%; display: inline-block; margin-top: 12.5%;">
                    <h2>Are you sure you want to delete your account from the database?</h2>
                    <h4 style="margin: 20px;">If you agree, your details will be permanently deleted and you will have to create a new account to use the service again.</h4>
                    <a href="account.php" class="btn btn-primary" style="width: 200px;margin-right: 15px; "><i class="icon-fire"></i>Cancel</a>
                    <a href="delete-account.php?account=delete" class="btn btn-primary" style="width: 200px;margin-right: 15px; background-color:red "><i class="icon-fire"></i>Delete Account</a>
                </div>
            </div>
        </section>
    </main>
    <style>
        .iframe {
            min-height: 250px;
            width: 100%;
            overflow: hidden;
            margin-bottom: -10px;
        }

        @media only screen and (max-width: 700px) {

            .iframe {
                min-height: 650px;
                width: 100%;
            }

        }
    </style>
    <?php
        include_once "components/footer.php";
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/Bootstrap-Tags-Input-1.js"></script>
    <script src="assets/js/Bootstrap-Tags-Input.js"></script>
</body>