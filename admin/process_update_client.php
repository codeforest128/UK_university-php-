<?php


	include('../../classes/DB.php');
	include('../../classes/login.php');
	
    if (!Login::isAdminLoggedIn()) {
         header("Location: login.php");
		}


		$id = $_POST['id'];
		$is_demo = $_POST['is_demo'];
		$student_limit = $_POST['student_limit'];


$update = DB::query('UPDATE clients SET is_demo="'.$is_demo.'",student_limit="'.$student_limit.'" WHERE id="'.$id.'"');

 header("Location: clients.php");
?>

