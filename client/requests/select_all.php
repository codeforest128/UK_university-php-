<?php
    include_once "../../../classes/DB.php";
    $t1 = preg_replace('/\s/', '', $_GET["key"]);
    $t2 = preg_replace('/\s/', '', $_COOKIE["ajax_ver"]);
    if ($t1 == $t2) {
        # Determine client id
        $token = $_COOKIE['SNID'];
        $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
        
        $sql = "SELECT student_id FROM `";
        # Determine type
        $request_still = true;
        switch($_GET["type"]) {
            case "CNTCT":
                $sql .= "contacts";
                break;
            case "SHRT":
                $sql .= "short_list";
                break;
            default:
                $request_still = false;
        }
        
        $response = "[";
        if ($request_still) {
            $sql .= "` WHERE client_id=:cid";
            $students = DB::query($sql, array(":cid" => $client_id));
            if (sizeof($students) == 0) {
                echo "\"No students selected\"";
            }
            foreach ($students as $stu) {
                $response .= "\"" . $stu["student_id"] . "\", ";
            }
            echo substr($response, 0, -2) . "]";
        } else {
            $students = $_SESSION["filters"]["executed"];
            foreach ($students as $stu) {
                $response .= "\"" . $stu . "\", ";
            }
            echo substr($response, 0, -2) . "]";
        }
        
        
    }
?>