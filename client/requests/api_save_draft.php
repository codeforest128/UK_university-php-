<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";

    print_r($_POST);
    

    $student_ids = $_POST['student_ids'];
    $client_id = $_POST['client_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $created_at = date('Y-m-d H:i:s');


    $check = DB::query("SELECT * FROM email_draft WHERE client_id='".$client_id."' AND student_ids='".$student_ids."'");

    if (empty($check)) {

    	if ($subject!='') {
    		$add = DB::query("INSERT INTO email_draft (client_id, student_ids, subject, message,created_at)
VALUES ('".$client_id."','".$student_ids."','".$subject."','".$message."','".$created_at."')");
    	}

    }else{

    	$idx = $check[0]['id'];

    	$update = DB::query("UPDATE email_draft SET subject='".$subject."', message='".$message."',created_at='".$created_at."' WHERE id='".$idx."'");
    }


    
?>