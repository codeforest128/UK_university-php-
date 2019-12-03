<?php
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
    
    $sql = "DELETE FROM client_login_token "
             . "WHERE client_id = :clientid";
    DB::query($sql, array(':clientid'=>Login::isClientLoggedIn()));
	header("Location: login.php");
?>