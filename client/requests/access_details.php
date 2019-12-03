<?php

    include_once "../../../classes/DB.php";
    $t1 = preg_replace('/\s/', '', $_GET["key"]);
    $t2 = preg_replace('/\s/', '', $_COOKIE["ajax_ver"]);
    if ($t1 == $t2) {
        if (isset($_GET["id"])) {
            # Gather general information
            // Get student id
            $id = $_GET["id"];
            // Get client id
            $token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];

            if ($_GET['checked']==0) {

                    # Update number of times student has been contacted
                $sql = "UPDATE `posts` "
                     . "SET times_contacted_this_month = times_contacted_this_month + 1 "
                     . "WHERE user_id=:stid";
                DB::query($sql, array(":stid" => $id));

                # Update contacts table
                $sql = "INSERT INTO `contacts` "
                     . "(student_id, client_id) "
                     . "VALUES (:stid, :cid)";
                DB::query($sql, array(":stid" => $id, ":cid" => $client_id));
                
            }

            if ($_GET['checked']==1) {

                    # Update number of times student has been contacted
                $sql = "UPDATE `posts` "
                     . "SET times_contacted_this_month = times_contacted_this_month - 1 "
                     . "WHERE user_id=:stid";
                DB::query($sql, array(":stid" => $id));


                # Update contacts table
                $sql = "DELETE FROM `contacts` WHERE student_id=:stid AND client_id=:cid";
                DB::query($sql, array(":stid" => $id, ":cid" => $client_id));
            
            }
            
            

            # Get information of student
            $sql = "SELECT p.firstname, p.lastname, u.email "
                 . "FROM `posts` p "
                 . "LEFT OUTER JOIN `users` u "
                 . "ON p.user_id = u.id "
                 . "WHERE p.user_id = :id";
            $details = DB::query($sql, array(":id" => $id))[0];
            $response = "{"
                      .     "\"fname\":\"" . $details["firstname"] . "\","
                      .     "\"lname\":\"" . $details["lastname"] . "\","
                      .     "\"email\":\"" . $details["email"] . "\""
                      . "}";
            echo $response;
        }
    }
?>