<?php
	include('../../classes/DB.php');
	include('../../classes/login.php');
	
        if (!Login::isClientLoggedIn()) {
         header("Location: login.php");
		}
		if (isset($_COOKIE['SNID']))	{			
			$token = $_COOKIE['SNID'];
			$clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
	
			$file_name = DB::query('SELECT file_name FROM images WHERE userid=:userid', array(':userid'=>$userid))[0]['file_name'];
				$sectors = "";
			$kind = "";
			
		}
		
		$details = DB::query('SELECT clients.*, client_details.* FROM clients INNER JOIN client_details ON clients.id=client_details.client_id 
		WHERE client_details.client_id = :clientid', array(':clientid'=> $clientid));
		
		if(array_key_exists('logout',$_POST)){
			  DB::query('DELETE FROM client_login_token WHERE client_id=:clientid', array(':clientid'=>Login::isClientLoggedIn()));
			  header("Location: login.php");
		}



    if (isset($_POST['user_id'])) {

      $student_id = $_POST['user_id'];
      $date = date('Y-m-d');

      $token = $_COOKIE['SNID'];
			$clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];

      $contact_check = DB::query('SELECT * FROM short_list WHERE student_id="'.$student_id.'" AND client_id="'.$clientid.'"' );



      if(!isset($contact_check[0]['id'])){

        $short_check = DB::query("INSERT INTO short_list (student_id, client_id, date)
VALUES ('$student_id', '$clientid', '$date')");

        echo $short_check;

      }
      
    }
		

?>