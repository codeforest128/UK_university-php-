<?php
    include('../classes/DB.php');
    include('../classes/login.php');

    if (Login::isLoggedIn()) {
        $id = $_POST["id"];
        $alt = $_POST["altemail"];
        DB::query("INSERT INTO `altemail` (student_id, email, verified) VALUES (:id, :email, 0)", array(":id" => $id, ":email" => $alt));
    }

    header("Location: account.php");
?>