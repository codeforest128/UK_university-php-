<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";
    

    $file_fatch = DB::query('SELECT * FROM images');

    echo json_encode($file_fatch);

    
?>