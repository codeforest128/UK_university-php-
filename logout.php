<?php
include_once "../classes/DB.php";
include_once "../classes/login.php";

DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid' => Login::isLoggedIn()));
header("Location: index.php");
exit;

?>