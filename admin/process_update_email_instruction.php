<?php


	include('../../classes/DB.php');
	include('../../classes/login.php');
	
    if (!Login::isAdminLoggedIn()) {
         header("Location: login.php");
		}


		$id = $_POST['id'];
		$client_email_instructions = $_POST['client_email_instructions'];



$update = DB::query('UPDATE settings SET value="'.$client_email_instructions.'" WHERE id="'.$id.'"');

  header("Location: clients.php");
?>

