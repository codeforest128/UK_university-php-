<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";
    $t1 = preg_replace('/\s/', '', $_GET["key"]);
    $t2 = preg_replace('/\s/', '', $_COOKIE["ajax_ver"]);
    if ($t1 == $t2) {
        if (isset($_GET["id"])) {
            
            # Fetch Client ID
            $token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
            
            # Fetch Client Notes
            $sql = "SELECT `notes_on_students` FROM `client_details` WHERE `client_id`=:cid";
            $notes = DB::query($sql, array(":cid" => $client_id))[0]["notes_on_students"];
            if ($notes == "") {
                echo "[]";
                exit;
            } else {
                $parsed_notes = json_decode($notes);
            }
            
            # Fetch Student ID
            $itd = $_GET["id"];
            if (isset($parsed_notes[$itd])) {
                echo json_encode($parsed_notes[$itd]);
            } else {
                echo "[]";
            }
        }
    }
?>