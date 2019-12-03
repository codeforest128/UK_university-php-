<?php
    include_once "../../../classes/DB.php";
    $t1 = preg_replace('/\s/', '', $_GET["key"]);
    $t2 = preg_replace('/\s/', '', $_COOKIE["ajax_ver"]);
    if ($t1 == $t2) {
        if (isset($_GET["id"])) {
            # Determine student id
            $stu_id = $_GET["id"];

            # Determine client id
            $token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];

            # Check they're not already shortlisted
            $sql = "SELECT COUNT(student_id) as amount FROM `short_list` WHERE student_id=:stid AND client_id=:cid";

            # Insert student into their shortlist
            if (DB::query($sql, array(":stid" => $stu_id, ":cid" => $client_id))[0]["amount"] == 0) {
                $sql = "INSERT INTO `short_list` (student_id, client_id) VALUES (:stid, :cid)";
                DB::query($sql, array(":stid" => $stu_id, ":cid" => $client_id));
            }
        }
    }
?>