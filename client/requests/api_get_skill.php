<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";
    

    $file_fatch = DB::query('SELECT * FROM posts');

    foreach ($file_fatch as $keyM => $valueM) {
    	print_r($valueM);
    }

    
?>