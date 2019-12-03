<?php
    include_once "../../../classes/DB.php";

        if (isset($_POST["hash"])) {

       $users = DB::query("SELECT users.id, users.email, users.username, posts.itd FROM users INNER JOIN posts ON users.id=posts.user_id;");

        	echo json_encode($users);
        	die();

        	

            
        }

 


?>