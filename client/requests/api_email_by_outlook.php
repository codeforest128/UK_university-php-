<?php
 header("Access-Control-Allow-Origin: *");
    include_once "../../../classes/DB.php";


    $students = $_POST['student_ids'];

    $student_emails = array();

    foreach ($students as $key => $value) {
        $users = DB::query("SELECT users.id, users.email FROM users INNER JOIN posts ON users.id=posts.user_id WHERE users.id='".$value."';");
        if (isset($users[0]['email'])) {
            $student_emails[] = $users[0]['email'];
        }
    }

    echo json_encode($student_emails);


?>