<?php
    include_once "../../../classes/DB.php";

        if (isset($_POST["id"])) {
            # Determine student id
            $stu_id = $_POST["id"];

            $type = $_POST['type'];

            # Determine client id
            $token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];


            if ($type=='add') {
                
                $already = DB::query('SELECT * FROM short_list WHERE student_id='.$stu_id.' AND client_id='.$client_id.'');

                if (count($already)==0) {

                    $insert = DB::query("INSERT INTO short_list (student_id, client_id) VALUES ('".$stu_id."', '".$client_id."')");

                }

            }

            if ($type=='remove') {

                $already = DB::query('SELECT * FROM short_list WHERE student_id='.$stu_id.' AND client_id='.$client_id.'');

                $uid = 0;

                foreach ($already as $key => $value) {
                   $uid =  $value['id'];
                }


                $delete = DB::query("DELETE FROM short_list WHERE id=".$uid);

                
            }


            
        }

?>